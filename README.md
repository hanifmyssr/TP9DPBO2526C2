# Aplikasi Manajemen Rekrutmen HR — MVP Strict Passive View

Aplikasi web CRUD berbasis PHP Native dan MySQL untuk mengelola data **Kandidat** dan **Lowongan Pekerjaan** menggunakan pola arsitektur **Model–View–Presenter (MVP)** dengan prinsip **Strict Passive View (*Dumb View*)**.

---

## Struktur Repositori

```text
MPV_Kandidat/
├── project/
│   ├── index.php
│   ├── models/
│   │   ├── DB.php
│   │   ├── Kandidat.php
│   │   ├── KontrakModel.php
│   │   ├── TabelKandidat.php
│   │   ├── Lowongan.php
│   │   ├── KontrakModelLowongan.php
│   │   └── TabelLowongan.php
│   ├── presenters/
│   │   ├── KontrakPresenter.php
│   │   ├── PresenterKandidat.php
│   │   ├── KontrakPresenterLowongan.php
│   │   └── PresenterLowongan.php
│   ├── views/
│   │   ├── KontrakView.php
│   │   ├── ViewKandidat.php
│   │   ├── KontrakViewLowongan.php
│   │   └── ViewLowongan.php
│   └── template/
│       ├── skin.html
│       ├── form.html
│       ├── skin_lowongan.html
│       └── form_lowongan.html
├── dokumentasi/
│   └── (simpan file screenrecord di sini)
├── mvp_db.sql
└── README.md
```

---

## Desain Program

### 1. Arsitektur MVP (Strict Passive View)
Setiap modul (`kandidat` dan `lowongan`) dipisahkan menjadi tiga lapisan utama yang berkomunikasi melalui **contract / interface**:

- **Model (`models/`)**
  - Entity class (`Kandidat`, `Lowongan`) merepresentasikan struktur data domain.
  - `DB` menyediakan koneksi PDO dan eksekusi *prepared statement* (`executeQuery`, `getAllResult`).
  - `TabelKandidat` mengimplementasikan `KontrakModel` dan `TabelLowongan` mengimplementasikan `KontrakModelLowongan` untuk operasi CRUD (`getAll`, `getById`, `add`, `update`, `delete`) menggunakan *prepared statement*.
- **View (`views/` & `template/`)**
  - `ViewKandidat` mengimplementasikan `KontrakView` dan `ViewLowongan` mengimplementasikan `KontrakViewLowongan`.
  - Menerapkan **Strict Passive View**: View tidak melakukan `require_once` terhadap Model/Entity, tidak memiliki perulangan (`foreach`), dan tidak menghitung agregat (`count()`). View hanya menerima string HTML baris tabel, total data, dan array data form dari Presenter lalu mengganti placeholder pada template HTML.
- **Presenter (`presenters/`)**
  - `PresenterKandidat` mengimplementasikan `KontrakPresenter` dan `PresenterLowongan` mengimplementasikan `KontrakPresenterLowongan`.
  - Bergantung hanya pada interface Model dan interface View.
  - Bertanggung jawab mengambil data dari Model, merakit HTML baris tabel (`buildRowHtml()`), menghitung total data, menyiapkan data *prefill* form edit, serta meneruskan aksi tambah/ubah/hapus ke Model lalu melakukan redirect.

### 2. Desain Database (`mvp_db.sql`)
Database `mvp_kandidat_db` memiliki dua tabel utama:
1. **`kandidat`**: `id`, `nama`, `posisi`, `domisili`, `skorTes`, `pengalamanTahun`.
2. **`lowongan`**: `id`, `judulPosisi`, `departemen`, `lokasi`, `kuota`, `status` (`Dibuka` / `Ditutup`).

---

## Penjelasan Alur Program

1. **Routing di `project/index.php`**
   - Parameter `page` (`$_POST['page'] ?? $_GET['page'] ?? 'kandidat'`) menentukan modul aktif: `kandidat` (default) atau `lowongan`.
   - `index.php` menginstansiasi pasangan `Model`, `View`, dan `Presenter` sesuai modul yang dipilih.
2. **Alur Request `GET` (Read & Form)**
   - `screen=list` (default): `index.php` memanggil `tampilkanKandidat()` / `tampilkanLowongan()`. Presenter mengambil seluruh data dari Model, merakit baris `<tr>...</tr>`, menghitung jumlah data, lalu memanggil `renderDaftar()` pada View.
   - `screen=add`: `index.php` memanggil `tampilkanFormKandidat()` / `tampilkanFormLowongan()` tanpa parameter ID untuk menampilkan form kosong dengan `action="tambah"`.
   - `screen=edit&id=...`: `index.php` memanggil `tampilkanFormKandidat($id)` / `tampilkanFormLowongan($id)`. Presenter mengambil data berdasarkan ID dari Model, menyiapkan array `$formData` (*prefill*), lalu memanggil `renderForm()` dengan `action="ubah"`.
3. **Alur Request `POST` (Create, Update, Delete)**
   - `action=tambah`: `index.php` meneruskan input form ke `tambahKandidat()` / `tambahLowongan()` pada Presenter, yang memanggil `add...()` di Model lalu redirect ke halaman daftar.
   - `action=ubah`: `index.php` meneruskan input form beserta `id` ke `ubahKandidat()` / `ubahLowongan()`, yang memanggil `update...()` di Model lalu redirect ke halaman daftar.
   - `action=hapus`: `index.php` meneruskan `id` ke `hapusKandidat()` / `hapusLowongan()`, yang memanggil `delete...()` di Model lalu redirect ke halaman daftar.

---

## Dokumentasi




https://github.com/user-attachments/assets/4e301485-4534-4f57-a8f0-6b8843dab9ab




