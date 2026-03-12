<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navigasi
    |--------------------------------------------------------------------------
    */
    'nav' => [
        'dashboard'  => 'Dasbor',
        'materials'  => 'Material',
        'inventory'  => 'Inventaris',
        'intake'     => 'Penerimaan',
        'outgoing'   => 'Pengeluaran',
        'categories' => 'Kategori',
        'reports'    => 'Laporan',
        'users'      => 'Pengguna',
        'profile'    => 'Profil',
        'logout'     => 'Keluar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    'auth' => [
        'login'                    => 'Masuk',
        'register'                 => 'Daftar',
        'logout'                   => 'Keluar',
        'email'                    => 'Email',
        'password'                 => 'Kata Sandi',
        'confirm_password'         => 'Konfirmasi Kata Sandi',
        'new_password'             => 'Kata Sandi Baru',
        'current_password'         => 'Kata Sandi Saat Ini',
        'remember_me'              => 'Ingat saya',
        'forgot_password'          => 'Lupa kata sandi?',
        'forgot_password_desc'     => 'Lupa kata sandi? Tidak masalah. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi.',
        'send_reset_link'          => 'Kirim Tautan Reset',
        'reset_password'           => 'Atur Ulang Kata Sandi',
        'already_registered'       => 'Sudah terdaftar?',
        'name'                     => 'Nama',
        'confirm_password_desc'    => 'Ini adalah area aman aplikasi. Harap konfirmasi kata sandi Anda sebelum melanjutkan.',
        'confirm'                  => 'Konfirmasi',
        'verify_email_desc'        => 'Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email, kami dengan senang hati akan mengirimkan yang baru.',
        'resend_verification'      => 'Kirim Ulang Email Verifikasi',
        'verification_sent'        => 'Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.',
        'unverified_email'         => 'Alamat email Anda belum diverifikasi.',
        'resend_verification_link' => 'Klik di sini untuk mengirim ulang email verifikasi.',
        'verification_link_sent'   => 'Tautan verifikasi baru telah dikirim ke alamat email Anda.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Umum
    |--------------------------------------------------------------------------
    */
    'general' => [
        'save'          => 'Simpan',
        'update'        => 'Perbarui',
        'cancel'        => 'Batal',
        'delete'        => 'Hapus',
        'edit'          => 'Edit',
        'view'          => 'Lihat',
        'submit'        => 'Simpan',
        'search'        => 'Cari',
        'filter'        => 'Filter',
        'reset'         => 'Reset',
        'back'          => 'Kembali',
        'add_item'      => '+ Tambah Item',
        'no_data'       => 'Belum ada data.',
        'saved'         => 'Tersimpan.',
        'required_mark' => '*',
        'created_by'    => 'Dibuat Oleh',
        'notes'         => 'Catatan',
        'items'         => 'Item',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dasbor
    |--------------------------------------------------------------------------
    */
    'dashboard' => [
        'title'               => 'Dasbor',
        'welcome'             => 'Selamat datang di Sistem Manajemen Gudang!',
        'total_materials'     => 'Total Material',
        'low_stock'           => 'Stok Rendah',
        'intake_this_month'   => 'Penerimaan Bulan Ini',
        'outgoing_this_month' => 'Pengeluaran Bulan Ini',
        'recent_intakes'      => 'Penerimaan Terbaru',
        'recent_outgoings'    => 'Pengeluaran Terbaru',
        'no_recent_intakes'   => 'Belum ada penerimaan.',
        'no_recent_outgoings' => 'Belum ada pengeluaran.',
        'view_all'            => 'Lihat Semua',
        'items_unit'          => 'jenis material',
        'orders_unit'         => 'transaksi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Profil
    |--------------------------------------------------------------------------
    */
    'profile' => [
        'title'                   => 'Profil',
        'update_info'             => 'Informasi Profil',
        'update_info_desc'        => 'Perbarui informasi profil dan alamat email akun Anda.',
        'update_password'         => 'Perbarui Kata Sandi',
        'update_password_desc'    => 'Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.',
        'delete_account'          => 'Hapus Akun',
        'delete_account_desc'     => 'Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi yang ingin Anda simpan.',
        'delete_account_confirm'  => 'Apakah Anda yakin ingin menghapus akun Anda?',
        'delete_account_warning'  => 'Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengkonfirmasi bahwa Anda ingin menghapus akun secara permanen.',
        'saved'                   => 'Tersimpan.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Kategori
    |--------------------------------------------------------------------------
    */
    'categories' => [
        'title'            => 'Kategori',
        'add'              => '+ Tambah Kategori',
        'create'           => 'Tambah Kategori',
        'edit'             => 'Edit Kategori',
        'name'             => 'Nama',
        'description'      => 'Deskripsi',
        'materials_count'  => 'Jumlah Material',
        'no_data'          => 'Belum ada kategori.',
        'confirm_delete'   => 'Hapus kategori ini?',
        'created'          => 'Kategori berhasil ditambahkan.',
        'updated'          => 'Kategori berhasil diperbarui.',
        'deleted'          => 'Kategori berhasil dihapus.',
        'delete_has_materials' => 'Tidak dapat menghapus kategori yang masih memiliki material.',
        'error_create'     => 'Gagal menambahkan kategori: :message',
        'error_update'     => 'Gagal memperbarui kategori: :message',
        'error_delete'     => 'Gagal menghapus kategori: :message',
    ],

    /*
    |--------------------------------------------------------------------------
    | Material
    |--------------------------------------------------------------------------
    */
    'materials' => [
        'title'           => 'Material',
        'add'             => '+ Tambah Material',
        'create'          => 'Tambah Material',
        'edit'            => 'Edit Material',
        'code'            => 'Kode',
        'name'            => 'Nama',
        'category'        => 'Kategori',
        'unit'            => 'Satuan',
        'min_stock'       => 'Stok Minimum',
        'description'     => 'Deskripsi',
        'select_category' => '-- Pilih Kategori --',
        'no_data'         => 'Belum ada material.',
        'confirm_delete'  => 'Hapus material ini?',
        'created'         => 'Material berhasil ditambahkan.',
        'updated'         => 'Material berhasil diperbarui.',
        'deleted'         => 'Material berhasil dihapus.',
        'error_create'    => 'Gagal menambahkan material: :message',
        'error_update'    => 'Gagal memperbarui material: :message',
        'error_delete'    => 'Gagal menghapus material: :message',
        'details'         => 'Detail Material',
        'back'            => '← Kembali ke Material',
        'below_min_stock' => '⚠ Stok di bawah minimum',
        'no_inventory'    => 'Belum ada catatan inventaris.',
        'unit_placeholder' => 'pcs, kg, liter…',
    ],

    /*
    |--------------------------------------------------------------------------
    | Inventaris
    |--------------------------------------------------------------------------
    */
    'inventory' => [
        'title'           => 'Inventaris',
        'search_placeholder' => 'Cari nama atau kode…',
        'low_stock_only'  => 'Stok rendah saja',
        'code'            => 'Kode',
        'name'            => 'Nama',
        'category'        => 'Kategori',
        'unit'            => 'Satuan',
        'stock'           => 'Stok',
        'min_stock'       => 'Stok Min',
        'status'          => 'Status',
        'status_ok'       => 'OK',
        'status_low'      => '⚠ Rendah',
        'no_data'         => 'Belum ada data inventaris.',
        'current_stock'   => 'Stok Saat Ini',
        'below_min'       => '⚠ Stok di bawah minimum (:min :unit)',
        'stock_ok'        => '✓ Stok mencukupi (min: :min :unit)',
        'last_updated'    => 'Terakhir diperbarui: :time',
        'no_record'       => 'Belum ada catatan inventaris. Stok akan muncul setelah penerimaan pertama.',
        'back'            => '← Kembali ke Inventaris',
        'details'         => 'Detail Material',
    ],

    /*
    |--------------------------------------------------------------------------
    | Penerimaan Material (Intake)
    |--------------------------------------------------------------------------
    */
    'intake' => [
        'title'              => 'Penerimaan Material',
        'create'             => 'Penerimaan Baru',
        'new'                => '+ Penerimaan Baru',
        'subtitle'           => 'Penerimaan Material',
        'reference_no'       => 'No. Referensi',
        'supplier'           => 'Pemasok',
        'received_at'        => 'Tanggal Penerimaan',
        'created_by'         => 'Dibuat Oleh',
        'notes'              => 'Catatan',
        'items'              => 'Item',
        'material'           => 'Material',
        'qty'                => 'Jml',
        'unit_price'         => 'Harga Satuan',
        'subtotal'           => 'Subtotal',
        'code'               => 'Kode',
        'select_material'    => '-- Pilih --',
        'search_placeholder' => 'Cari referensi atau pemasok…',
        'no_data'            => 'Belum ada penerimaan material.',
        'created'            => 'Penerimaan berhasil disimpan. Inventaris telah diperbarui.',
        'error_create'       => 'Gagal menyimpan penerimaan: :message',
        'back'               => '← Kembali ke Penerimaan',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pengeluaran Material (Outgoing)
    |--------------------------------------------------------------------------
    */
    'outgoing' => [
        'title'              => 'Pengeluaran Material',
        'create'             => 'Pengeluaran Baru',
        'new'                => '+ Pengeluaran Baru',
        'subtitle'           => 'Pengeluaran Material — Produksi Internal',
        'reference_no'       => 'No. Referensi',
        'department'         => 'Departemen / Lini Produksi',
        'issued_at'          => 'Tanggal Pengeluaran',
        'created_by'         => 'Dibuat Oleh',
        'notes'              => 'Catatan',
        'items'              => 'Item',
        'material'           => 'Material',
        'stock'              => 'Stok',
        'qty'                => 'Jml',
        'code'               => 'Kode',
        'select_material'    => '-- Pilih --',
        'dept_placeholder'       => 'cth. Lini Produksi A, Perakitan',
        'department_placeholder' => 'cth. Lini Produksi A, Perakitan',
        'show_subtitle'          => 'Pengeluaran Material — Produksi Internal',
        'search_placeholder' => 'Cari referensi atau departemen…',
        'no_data'            => 'Belum ada pengeluaran material.',
        'created'            => 'Pengeluaran material berhasil dicatat. Inventaris telah dikurangi.',
        'error_stock'        => 'Stok tidak mencukupi untuk material yang dipilih.',
        'error_create'       => 'Gagal menyimpan pengeluaran: :message',
        'back'               => '← Kembali ke Pengeluaran',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */
    'reports' => [
        'title'                   => 'Laporan',
        'intake_title'            => 'Laporan Penerimaan Material',
        'outgoing_title'          => 'Laporan Pengeluaran Material',
        'inventory_title'         => 'Laporan Inventaris',
        'date_from'               => 'Tanggal Dari',
        'date_to'                 => 'Tanggal Sampai',
        'supplier_filter'         => 'Pemasok (opsional)',
        'department_filter'       => 'Departemen (opsional)',
        'category_filter'         => 'Kategori (opsional)',
        'low_stock_only'          => 'Hanya stok rendah',
        'export_excel'            => 'Ekspor Excel',
        'select_category'         => '-- Semua Kategori --',
        'intake_desc'             => 'Ekspor data penerimaan material berdasarkan rentang tanggal dan pemasok.',
        'outgoing_desc'           => 'Ekspor data pengeluaran material berdasarkan rentang tanggal dan departemen.',
        'inventory_desc'          => 'Ekspor data stok inventaris saat ini beserta status stok rendah.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Manajemen Pengguna
    |--------------------------------------------------------------------------
    */
    'users' => [
        'title'                    => 'Manajemen Pengguna',
        'add'                      => '+ Tambah Pengguna',
        'create'                   => 'Tambah Pengguna',
        'name'                     => 'Nama',
        'email'                    => 'Email',
        'role'                     => 'Peran',
        'status'                   => 'Status',
        'you'                      => 'Anda',
        'no_data'                  => 'Belum ada pengguna.',
        'select_role'              => '-- Pilih Peran --',
        'role_admin'               => 'Admin',
        'role_user'                => 'User',
        'must_change_password'     => '⚠ Harus ganti kata sandi',
        'confirm_delete'           => 'Hapus pengguna ini?',
        'created'                  => 'Pengguna berhasil ditambahkan.',
        'deleted'                  => 'Pengguna berhasil dihapus.',
        'cannot_delete_self'       => 'Tidak dapat menghapus akun Anda sendiri.',
        'temp_password_info'       => 'Password sementara akan dibuat otomatis. Pengguna harus mengganti password saat pertama kali login.',
        'temp_password_notice_title' => 'Password sementara untuk pengguna baru:',
        'temp_password_notice'     => 'Nama: :name — Password: :password',
        'temp_password_warning'    => 'Catat password ini sekarang, karena tidak akan ditampilkan lagi.',
        'error_create'             => 'Gagal menambahkan pengguna: :message',
        'error_delete'             => 'Gagal menghapus pengguna: :message',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ganti Kata Sandi (Paksa)
    |--------------------------------------------------------------------------
    */
    'change_password' => [
        'title'            => 'Ganti Kata Sandi',
        'notice'           => 'Anda harus mengganti kata sandi sebelum dapat melanjutkan menggunakan aplikasi.',
        'new_password'     => 'Kata Sandi Baru',
        'confirm_password' => 'Konfirmasi Kata Sandi Baru',
        'submit'           => 'Simpan Kata Sandi',
        'updated'          => 'Kata sandi berhasil diperbarui.',
    ],

];
