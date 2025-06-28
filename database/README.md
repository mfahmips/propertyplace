# PropertyPlace SQL Database

## 📥 Cara Import

1. Buka [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Buat database baru dengan nama `propertyplace`
3. Pilih database tersebut → klik tab **Import**
4. Upload file `propertyplace.sql`
5. Klik **Go**

## 🗃️ Isi Tabel

| Tabel | Keterangan |
|-------|------------|
| `properties` | Menyimpan daftar properti (judul, lokasi, harga, deskripsi, tanggal buat) |

Contoh properti:
- Rumah Cluster BSD – Rp1.5M
- Apartemen Sudirman – Rp950Jt

---

## ⚠️ Catatan

- File ini hanya berisi data contoh, silakan sesuaikan dengan kebutuhan produksi.
- Pastikan `.env` mengarah ke database `propertyplace`.
