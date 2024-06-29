<!-- [ApplicationUpdateContent] START-->
    <h5>
        <!-- [ApplicationUpdateContent].[Title] START-->
        This page has migrated from TDE 1.0
        <!-- [ApplicationUpdateContent].[Title] END-->
    </h5>
    <br/>
    <!-- [ApplicationUpdateContent].[Content] START-->
    <p>
        Halaman <a href='/TDE/Gaia/aftersales/plutususer'>User Plutus</a> pada applikasi <a href='/TDE/Gaia'>Gaia</a> modul <a href='/TDE/Gaia/aftersales'>After Sales</a> sudah tersedia di TDE 2.0.
        Halaman ini adalah halaman migrasi dari <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=42'>TDE 1.0 ini</a>.
        Halaman ini terbagi jadi 2 metode pencarian, berdasarkan Karyawan (<i class='fa-solid fa-users'></i> User Access) dan bersarkan Cabang (<i class='fa-solid fa-building'></i> Branch Access).
        2 Metode ini dapat dipilih dari menu samping yang terletak di sebelah kiri halaman.
        Akses Plutus dikategorikan kedalam 4 macam akses.
        <br/>-<span class='text-success fw-bold'>C</span> singkatan dari <span class='text-success fw-bold'>CREATE</span>, yaitu akses menambah, membuat dan mengunduh data pada sistem Plutus.
        <br/>-<span class='fw-bold'>R</span> singkatan dari <span class='fw-bold'>READ</span>, yaitu akses membaca dan membuka data pada sistem Plutus. <em>Akses ini adalah akses default dari karyawan.</em>
        <br/>-<span class='text-primary fw-bold'>U</span> singkatan dari <span class='text-primary fw-bold'>UPDATE</span>, yaitu akses mengubah data pada sistem Plutus.
        <br/>-<span class='text-danger fw-bold'>D</span> singkatan dari <span class='text-danger fw-bold'>DELETE</span>, yaitu akses memhapus dan membatalkan data pada sistem Plutus.
    </p>

    <br/><h6><i class='fa-solid fa-users'></i> User Access</h6>
    <p>
        Dari sudut pandang Karyawan, anda bisa mencari akses karyawan untuk modul dan halaman pada Plutus. Opsi pencarian yang disediakan adalah sebagai berikut
    </p>
    <div class='table-responsive'>
        <table class='table table-sm table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Inputan</th>
                    <th scope='col'>Sifat</th>
                    <th scope='col'>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope='row'>1</td>
                    <td>Branch</td>
                    <td><span class='fw-bold text-danger'>Mandatory : Merek</span><br/>Opsional : PT dan Cabang</td>
                    <td>Untuk memfilter pencarian berdasarkan Merk, PT dan Cabang</td>
                </tr>
                <tr>
                    <td scope='row'>2</td>
                    <td>Employee NIP</td>
                    <td>Opsional, default : 0</td>
                    <td>Untuk memfilter pencarian berdasarkan Nomor Induk karyawan</td>
                </tr>
                <tr>
                    <td scope='row'>3</td>
                    <td>Employee Nama</td>
                    <td>Opsional</td>
                    <td>Untuk memfilter pencarian berdasarkan Nama karyawan</td>
                </tr>
                <tr>
                    <td scope='row'>4</td>
                    <td>Employee Status</td>
                    <td>Opsional, default : All</td>
                    <td>Untuk memfilter pencarian berdasarkan Status karyawan.
                        <br/><strong>All</strong> adalah semua karyawan baik yang sudah tidak aktif, masih aktif, maupun belum aktif.
                        <br/><strong>Active Employee</strong> adalah karyawan yang masih aktif masa kerjanya.
                        <br/><strong>Inactive Employee</strong> adalah karyawan yang sudah tidak aktif masa kerjanya</td>
                </tr>
                <tr>
                    <td scope='row'>5</td>
                    <td>Access</td>
                    <td>Opsional, default : Any Access</td>
                    <td>Untuk memfilter pencarian berdasarkan Akses karyawan.
                        <br/><strong>All Status</strong> adalah semua status akses, baik yang sudah ada akses maupun yang belum ada.
                        <br/><strong>Can Create</strong> adalah minimal memiliki akses membuat / menambah (Create).
                        <br/><strong>Can Read</strong> adalah minimal memiliki akses membaca (Create).
                        <br/><strong>Can Update</strong> adalah minimal memiliki akses mengubah (Update).
                        <br/><strong>Can Delete</strong> adalah minimal memiliki akses menghapus / membatalkan (Delete).
                        <br/><strong>Any Delete</strong> adalah minimal memiliki akses.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br/><strong>Konfigurasi Akses</strong>
    <p>
        Setiap baris pada hasil pencarian adalah 1 karyawan. Di baris ini terdapat keterangan Nama Lengkap, Nomor Induk, Area / Penempatan lokasi kerja dan Jabatan.
        Bila karyawan memiliki akses, terdapat shortcut tombol <button class='btn btn-sm btn-danger'> REMOVE ALL ACCESS</button> untuk membuang semua akses karyawan untuk semua Modul dan Halaman Plutus After sales untuk semua POS yang dicari.
        <span class='text-warning'>Perhatian : Aksi ini tidak dapat di-undo</span>
    </p>
    <br/><p>
        Di setiap baris karyawan, terdapat sub tabel yang menunjukkan konfigurasi akses untuk tiap Halaman dan POS.
        Sub table ini dapat dibuka dengan menekan tombol <a class='k-icon k-i-expand'></a> pada kolom paling kiri dari baris karyawan.

        <br/><br/>Untuk kolom POS yang sudah pernah ada konfigurasi aksesnya, akan ada tombol <button class='btn btn-sm btn-danger'><i class='fa-solid fa-ban'></i> REMOVE ACCESS TO ALL PAGES</button></span> yang dapat ditekan untuk mengapus semua akses di semua halaman di POS tersebut

        <br/><br/>Untuk menambah akses, silahkan klik tulisan <span class='text-decoration-underline text-nu'>SET ACCESS</span>
        , lalu pilih akses yang ingin diberikan
        dan tekan tombol <div class='btn btn-sm btn-primary'><i class='fa-solid fa-pencil'></i> SET ACCESS</div> untuk menambah akses.

        <br/><br/>Untuk mengubah akses, silahkan klik tulisan <span class='text-decoration-underline text-success'>C</span> atau <span class='text-decoration-underline'>R</span> atau <span class='text-decoration-underline text-primary'>U</span> atau <span class='text-decoration-underline text-danger'>D</span>
        , lalu konfigurasi ulang akses yang ingin diberikan
        dan tekan tombol <div class='btn btn-sm btn-primary'><i class='fa-solid fa-pencil'></i> SET ACCESS</div> untuk merubah akses.

        <br/><br/>Untuk membuang akses, silahkan klik tulisan <span class='text-decoration-underline text-success'>C</span> atau <span class='text-decoration-underline'>R</span> atau <span class='text-decoration-underline text-primary'>U</span> atau <span class='text-decoration-underline text-danger'>D</span>
        , lalu tekan tombol <div class='btn btn-sm btn-danger'><i class='fa-solid fa-ban'></i> REMOVE ACCESS</div> untuk menghapus akses.
    </p>

    <br/><h6><i class='fa-solid fa-building'></i> Branch Access</h6>
    <p>
        Dari sudut pandang Cabang, anda bisa mencari akses yang s untuk modul dan halaman pada Plutus. Opsi pencarian yang disediakan adalah sebagai berikut
    </p>
    <div class='table-responsive'>
        <table class='table table-sm table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Inputan</th>
                    <th scope='col'>Sifat</th>
                    <th scope='col'>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope='row'>1</td>
                    <td>Branch</td>
                    <td><span class='fw-bold text-danger'>Mandatory : Merek, PT dan Cabang</span></td>
                    <td>Untuk memfilter pencarian berdasarkan Merk, PT dan Cabang</td>
                </tr>
                <tr>
                    <td scope='row'>2</td>
                    <td>Employee NIP</td>
                    <td>Opsional, default : 0</td>
                    <td>Untuk memfilter pencarian berdasarkan Nomor Induk karyawan</td>
                </tr>
                <tr>
                    <td scope='row'>3</td>
                    <td>Employee Nama</td>
                    <td>Opsional</td>
                    <td>Untuk memfilter pencarian berdasarkan Nama karyawan</td>
                </tr>
            </tbody>
        </table>
    </div>

    <br/><strong>Konfigurasi Akses</strong>
    <p>
        Setiap baris pada hasil pencarian adalah 1 POS. Di baris ini terdapat keterangan Nama POS.
        Di setiap baris POS, terdapat sub tabel yang menunjukkan konfigurasi akses untuk tiap Karyawan dan Halaman.
        Sub table ini dapat dibuka dengan menekan tombol <a class='k-icon k-i-expand'></a> pada kolom paling kiri dari baris POS.

        <br/><br/>Terdapat tombol <button class='btn btn-sm btn-danger'><i class='fa-solid fa-ban'></i> DELETE ALL ACCESS</button></span> yang dapat ditekan untuk mengapus semua akses di semua halaman di POS tersebut

        <br/><br/>Untuk menambah akses, silahkan klik tulisan <span class='text-decoration-underline text-nu'>SET ACCESS</span>
        , lalu pilih akses yang ingin diberikan
        dan tekan tombol <div class='btn btn-sm btn-primary'><i class='fa-solid fa-pencil'></i> SET ACCESS</div> untuk menambah akses.

        <br/><br/>Untuk mengubah akses, silahkan klik tulisan <span class='text-decoration-underline text-success'>C</span> atau <span class='text-decoration-underline'>R</span> atau <span class='text-decoration-underline text-primary'>U</span> atau <span class='text-decoration-underline text-danger'>D</span>
        , lalu konfigurasi ulang akses yang ingin diberikan
        dan tekan tombol <div class='btn btn-sm btn-primary'><i class='fa-solid fa-pencil'></i> SET ACCESS</div> untuk merubah akses.

        <br/><br/>Untuk membuang akses, silahkan klik tulisan <span class='text-decoration-underline text-success'>C</span> atau <span class='text-decoration-underline'>R</span> atau <span class='text-decoration-underline text-primary'>U</span> atau <span class='text-decoration-underline text-danger'>D</span>
        , lalu tekan tombol <div class='btn btn-sm btn-danger'><i class='fa-solid fa-ban'></i> REMOVE ACCESS</div> untuk menghapus akses.
    </p>
    <!-- [ApplicationUpdateContent].[Content] END-->
<!-- [ApplicationUpdateContent] END-->
