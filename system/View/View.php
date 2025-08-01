<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\View;

use CodeIgniter\Autoloader\FileLocatorInterface;
use CodeIgniter\Debug\Toolbar\Collectors\Views;
use CodeIgniter\Exceptions\RuntimeException;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\View\Exceptions\ViewException;
use Config\Toolbar;
use Config\View as ViewConfig;
use Psr\Log\LoggerInterface;

/**
 * Class View
 *
 * @see \CodeIgniter\View\ViewTest
 */
class View implements RendererInterface
{
    use ViewDecoratorTrait;

    /**
     * Saved Data.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Data for the variables that are available in the Views.
     *
     * @var array<string, mixed>|null
     */
    protected $tempData;

    /**
     * The base directory to look in for our Views.
     *
     * @var string
     */
    protected $viewPath;

    /**
     * Data for rendering including Caching and Debug Toolbar data.
     *
     * @var array<string, mixed>
     */
    protected $renderVars = [];

    /**
     * Instance of FileLocator for when
     * we need to attempt to find a view
     * that's not in standard place.
     *
     * @var FileLocatorInterface
     */
    protected $loader;

    /**
     * Logger instance.
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Should we store performance info?
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * Cache stats about our performance here,
     * when CI_DEBUG = true
     *
     * @var list<array{start: float, end: float, view: string}>
     */
    protected $performanceData = [];

    /**
     * @var ViewConfig
     */
    protected $config;

    /**
     * Whether data should be saved between renders.
     *
     * @var bool
     */
    protected $saveData;

    /**
     * Number of loaded views
     *
     * @var int
     */
    protected $viewsCount = 0;

    /**
     * The name of the layout being used, if any.
     * Set by the `extend` method used within views.
     *
     * @var string|null
     */
    protected $layout;

    /**
     * Holds the sections and their data.
     *
     * @var array<string, list<string>>
     */
    protected $sections = [];

    /**
     * The name of the current section being rendered,
     * if any.
     *
     * @var list<string>
     */
    protected $sectionStack = [];

    public function __construct(
        ViewConfig $config,
        ?string $viewPath = null,
        ?FileLocatorInterface $loader = null,
        ?bool $debug = null,
        ?LoggerInterface $logger = null,
    ) {
        $this->config   = $config;
        $this->viewPath = rtrim($viewPath, '\\/ ') . DIRECTORY_SEPARATOR;
        $this->loader   = $loader ?? service('locator');
        $this->logger   = $logger ?? service('logger');
        $this->debug    = $debug ?? CI_DEBUG;
        $this->saveData = (bool) $config->saveData;
    }

    /**
     * Builds the output based upon a file name and any
     * data that has already been set.
     *
     * Valid $options:
     *  - cache      Number of seconds to cache for
     *  - cache_name Name to use for cache
     *
     * @param string                    $view     File name of the view source
     * @param array<string, mixed>|null $options  Reserved for 3rd-party uses since
     *                                            it might be needed to pass additional info
     *                                            to other template engines.
     * @param bool|null                 $saveData If true, saves data for subsequent calls,
     *                                            if false, cleans the data after displaying,
     *                                            if null, uses the config setting.
     */
    public function render(string $view, ?array $options = null, ?bool $saveData = null): string
    {
        $this->renderVars['start'] = microtime(true);

        // Store the results here so even if
        // multiple views are called in a view, it won't
        // clean it unless we mean it to.
        $saveData ??= $this->saveData;

        $fileExt = pathinfo($view, PATHINFO_EXTENSION);
        // allow Views as .html, .tpl, etc (from CI3)
        $this->renderVars['view'] = ($fileExt === '') ? $view . '.php' : $view;

        $this->renderVars['options'] = $options ?? [];

        // Was it cached?
        if (isset($this->renderVars['options']['cache'])) {
            $cacheName = $this->renderVars['options']['cache_name']
                ?? str_replace('.php', '', $this->renderVars['view']);
            $cacheName = str_replace(['\\', '/'], '', $cacheName);

            $this->renderVars['cacheName'] = $cacheName;

            $output = cache($this->renderVars['cacheName']);

            if (is_string($output) && $output !== '') {
                $this->logPerformance(
                    $this->renderVars['start'],
                    microtime(true),
                    $this->renderVars['view'],
                );

                return $output;
            }
        }

        $this->renderVars['file'] = $this->viewPath . $this->renderVars['view'];

        if (! is_file($this->renderVars['file'])) {
            $this->renderVars['file'] = $this->loader->locateFile(
                $this->renderVars['view'],
                'Views',
                ($fileExt === '') ? 'php' : $fileExt,
            );
        }

        // locateFile() will return false if the file cannot be found.
        if ($this->renderVars['file'] === false) {
            throw ViewException::forInvalidFile($this->renderVars['view']);
        }

        // Make our view data available to the view.
        $this->prepareTemplateData($saveData);

        // Save current vars
        $renderVars = $this->renderVars;

        $output = (function (): string {
            extract($this->tempData);
            ob_start();
            include $this->renderVars['file'];

            return ob_get_clean() ?: '';
        })();

        // Get back current vars
        $this->renderVars = $renderVars;

        // When using layouts, the data has already been stored
        // in $this->sections, and no other valid output
        // is allowed in $output so we'll overwrite it.
        if ($this->layout !== null && $this->sectionStack === []) {
            $layoutView   = $this->layout;
            $this->layout = null;
            // Save current vars
            $renderVars = $this->renderVars;
            $output     = $this->render($layoutView, $options, $saveData);
            // Get back current vars
            $this->renderVars = $renderVars;
        }

        $output = $this->decorateOutput($output);

        $this->logPerformance(
            $this->renderVars['start'],
            microtime(true),
            $this->renderVars['view'],
        );

        // Check if DebugToolbar is enabled.
        $filters              = service('filters');
        $requiredAfterFilters = $filters->getRequiredFilters('after')[0];
        if (in_array('toolbar', $requiredAfterFilters, true)) {
            $debugBarEnabled = true;
        } else {
            $afterFilters    = $filters->getFiltersClass()['after'];
            $debugBarEnabled = in_array(DebugToolbar::class, $afterFilters, true);
        }

        if (
            $this->debug && $debugBarEnabled
            && (! isset($options['debug']) || $options['debug'] === true)
        ) {
            $toolbarCollectors = config(Toolbar::class)->collectors;

            if (in_array(Views::class, $toolbarCollectors, true)) {
                // Clean up our path names to make them a little cleaner
                $this->renderVars['file'] = clean_path($this->renderVars['file']);
                $this->renderVars['file'] = ++$this->viewsCount . ' ' . $this->renderVars['file'];

                $output = '<!-- DEBUG-VIEW START ' . $this->renderVars['file'] . ' -->' . PHP_EOL
                    . $output . PHP_EOL
                    . '<!-- DEBUG-VIEW ENDED ' . $this->renderVars['file'] . ' -->' . PHP_EOL;
            }
        }

        // Should we cache?
        if (isset($this->renderVars['options']['cache'])) {
            cache()->save(
                $this->renderVars['cacheName'],
                $output,
                (int) $this->renderVars['options']['cache'],
            );
        }

        $this->tempData = null;

        return $output;
    }

    /**
     * Builds the output based upon a string and any
     * data that has already been set.
     * Cache does not apply, because there is no "key".
     *
     * @param string                    $view     The view contents
     * @param array<string, mixed>|null $options  Reserved for 3rd-party uses since
     *                                            it might be needed to pass additional info
     *                                            to other template engines.
     * @param bool|null                 $saveData If true, saves data for subsequent calls,
     *                                            if false, cleans the data after displaying,
     *                                            if null, uses the config setting.
     */
    public function renderString(string $view, ?array $options = null, ?bool $saveData = null): string
    {
        $start = microtime(true);
        $saveData ??= $this->saveData;
        $this->prepareTemplateData($saveData);

        $output = (function (string $view): string {
            extract($this->tempData);
            ob_start();
            eval('?>' . $view);

            return ob_get_clean() ?: '';
        })($view);

        $this->logPerformance($start, microtime(true), $this->excerpt($view));
        $this->tempData = null;

        return $output;
    }

    /**
     * Extract first bit of a long string and add ellipsis
     */
    public function excerpt(string $string, int $length = 20): string
    {
        return (mb_strlen($string) > $length) ? mb_substr($string, 0, $length - 3) . '...' : $string;
    }

    /**
     * Sets several pieces of view data at once.
     *
     * @param 'attr'|'css'|'html'|'js'|'raw'|'url'|null $context The context to escape it for.
     *                                                           If 'raw', no escaping will happen.
     */
    public function setData(array $data = [], ?string $context = null): RendererInterface
    {
        if ($context !== null) {
            $data = \esc($data, $context);
        }

        $this->tempData ??= $this->data;
        $this->tempData = array_merge($this->tempData, $data);

        return $this;
    }

    /**
     * Sets a single piece of view data.
     *
     * @param mixed                                     $value
     * @param 'attr'|'css'|'html'|'js'|'raw'|'url'|null $context The context to escape it for.
     *                                                           If 'raw', no escaping will happen.
     */
    public function setVar(string $name, $value = null, ?string $context = null): RendererInterface
    {
        if ($context !== null) {
            $value = esc($value, $context);
        }

        $this->tempData ??= $this->data;
        $this->tempData[$name] = $value;

        return $this;
    }

    /**
     * Removes all of the view data from the system.
     */
    public function resetData(): RendererInterface
    {
        $this->data = [];

        return $this;
    }

    /**
     * Returns the current data that will be displayed in the view.
     *
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->tempData ?? $this->data;
    }

    /**
     * Specifies that the current view should extend an existing layout.
     *
     * @return void
     */
    public function extend(string $layout)
    {
        $this->layout = $layout;
    }

    /**
     * Starts holds content for a section within the layout.
     *
     * @param string $name Section name
     *
     * @return void
     */
    public function section(string $name)
    {
        $this->sectionStack[] = $name;

        ob_start();
    }

    /**
     * Captures the last section
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function endSection()
    {
        $contents = ob_get_clean();

        if ($this->sectionStack === []) {
            throw new RuntimeException('View themes, no current section.');
        }

        $section = array_pop($this->sectionStack);

        // Ensure an array exists so we can store multiple entries for this.
        if (! array_key_exists($section, $this->sections)) {
            $this->sections[$section] = [];
        }

        $this->sections[$section][] = $contents;
    }

    /**
     * Renders a section's contents.
     *
     * @param bool $saveData If true, saves data for subsequent calls,
     *                       if false, cleans the data after displaying.
     */
    public function renderSection(string $sectionName, bool $saveData = false): string
    {
        if (! isset($this->sections[$sectionName])) {
            return '';
        }

        $output = '';

        foreach ($this->sections[$sectionName] as $key => $contents) {
            $output .= $contents;
            if ($saveData === false) {
                unset($this->sections[$sectionName][$key]);
            }
        }

        return $output;
    }

    /**
     * Used within layout views to include additional views.
     *
     * @param array<string, mixed>|null $options
     * @param bool                      $saveData
     */
    public function include(string $view, ?array $options = null, $saveData = true): string
    {
        return $this->render($view, $options, $saveData);
    }

    /**
     * Returns the performance data that might have been collected
     * during the execution. Used primarily in the Debug Toolbar.
     *
     * @return list<array{start: float, end: float, view: string}>
     */
    public function getPerformanceData(): array
    {
        return $this->performanceData;
    }

    /**
     * Logs performance data for rendering a view.
     *
     * @return void
     */
    protected function logPerformance(float $start, float $end, string $view)
    {
        if ($this->debug) {
            $this->performanceData[] = [
                'start' => $start,
                'end'   => $end,
                'view'  => $view,
            ];
        }
    }

    protected function prepareTemplateData(bool $saveData): void
    {
        $this->tempData ??= $this->data;

        if ($saveData) {
            $this->data = $this->tempData;
        }
    }
}
