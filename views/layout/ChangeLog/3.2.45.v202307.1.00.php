<!-- [ApplicationUpdateContent] START-->
    <h5>
        <!-- [ApplicationUpdateContent].[Title] START-->
        This page has migrated from TDE 1.0
        <!-- [ApplicationUpdateContent].[Title] END-->
    </h5>
    <br/>
    <!-- [ApplicationUpdateContent].[Content] START-->
    <p>
        Halaman <a href='/TDE/Plutus/finance/titipan'>Titipan Pelanggan</a> pada applikasi <a href='/TDE/Plutus'>Plutus</a> modul <a href='/TDE/Plutus/finance'>Fiannce</a> sudah tersedia di TDE 2.0.
        Halaman ini adalah halaman migrasi dari <a href='https://vibi.trimandirigroup.com:5431/plutus/main.php?modul=4&submodul=45'>TDE 1.0 ini</a>.
        Walau demikian, fitur pertama yang dapat digunakan di halaman ini adalah Titipan DSC (Daihatsu Service Kontrak), sedang untuk Titipan SPK dan Aksesoris masih dalam proses migrasi.
    </p>
    <br/><br/>
    <h5>
        <!-- [ApplicationUpdateContent].[Title] START-->
        Titipan DSC
        <!-- [ApplicationUpdateContent].[Title] END-->
    </h5>
    <br/>
    <!-- [ApplicationUpdateContent].[Content] START-->
    <p>
        Menu untuk titipan (<img class="subpage_menu_icon" src="/TDE/Plutus/resources/images/subpage/45dsc.png"> Daihatsu Service Contract dapat diakses dari menu samping yang terletak di sebelah kiri halaman.
        Opsi pencarian yang disediakan adalah sebagai berikut
    </p>
    <div class='table-responsive'>
        <table class='table table-sm table-striped table-hover'>
            <thead class='table-dark'>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col' width="100px">Inputan</th>
                    <th scope='col'>Sifat</th>
                    <th scope='col'>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope='row'>1</td>
                    <td>POS</td>
                    <td><span class='fw-bold text-danger'>Mandatory</span></td>
                    <td>Untuk memfilter pencarian berdasarkan POS</td>
                </tr>
                <tr>
                    <td scope='row'>2</td>
                    <td>Tanggal</td>
                    <td><span class='fw-bold text-danger'>Mandatory</span>, default : awal bulan s/d hari ini</td>
                    <td>Untuk memfilter pencarian berdasarkan tanggal penjurnalan (Tanggal Posting) atau tanggal dokumen (Tanggal Cetakan)</td>
                </tr>
                <tr>
                    <td scope='row'>3</td>
                    <td>No Dokumen</td>
                    <td>Opsional</td>
                    <td>Untuk memfilter pencarian no dokumen. Opsi dokumen yang dapat dipilih adalah No Plutus, No Cetakan dan No Referensi</td>
                </tr>
                <tr>
                    <td scope='row'>4</td>
                    <td>Tipe</td>
                    <td><span class='fw-bold text-danger'>Mandatory</span>, default : TTDSC1</td>
                    <td>Untuk memfilter pencarian berdasarkan Tipe Titipan. Untuk sekarang, hanya terdapat 1 pilihan, yaitu TTDSC1.</td>
                </tr>
                <tr>
                    <td scope='row'>5</td>
                    <td>No Mesin</td>
                    <td>Opsional</td>
                    <td>Untuk memfilter pencarian berdasarkan No Mesin kendaraan konsumen.</td>
                    </td>
                </tr>
                <tr>
                    <td scope='row'>6</td>
                    <td>Status</td>
                    <td><span class='fw-bold text-danger'>Mandatory</span>, default : ALL</td>
                    <td>Untuk memfilter pencarian berdasarkans status titipan.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p>
        Untuk mencari data titipan berdasarkan isian filter, silahkn tekan Enter pada keyboard, atau klik tombol <button class="btn btn-sm btn-search"><i class="fa-solid fa-search"></i> CARI</button>.
        Bila tidak ditemukan data titipan berdasarkan isian filter yang Anda pilih, maka sistem akan mengeluarkan informasi "Tidak ada titipan dengan spesifikasi pencarian tersebut".
        Bila terdapat data titipan yang sesuai dengan isian filter yang Anda pilih, maka list titipan akan muncul di tabel list titipan di bagian bawah.
        Apapun informasi yang dikeluarkan adalah
        <br/>1. Kolom Aksi : Kolom ini berisikan tombol-tombol proses yang dapat dilakukan pada titipan, tergantung status titipan tersebut.
        <br/>2. Kolom Titipan : No Dokumen Plutus, Status Titipan, No Cetakan, No Referensi, Tanggal Posting, Tanggal Dokumen, Depositor dan Metode
        <br/>3. Kendaraan dan Konsumen : Tipe Kendaraan, Warna Kendaraan, No Mesin, No Rangka, Nama Konsumen, No KTP dan No Handphone
        <br/>4. Nominal: Berisikan nominal Titipan, nominal Penggunaan dan nominal sisa Saldo.
    </p>

    <br/>
    <section>
        <strong><i class="fa-solid fa-plus"></i> Menambah Titipan DSC</strong>
        <p>
            Proses ini hanya dapat dilakan oleh User Login dengan akses Create (C) pada halaman titipan.
            Adapun langkah dalam menambah data titipan DSC adalah sebagai berikut
        </p>
        <p>1. Untuk menambah data titipan DSC, silahkan klik tombol <button class="btn btn-sm btn-add"><i class="fa-solid fa-plus"></i> TAMBAH</button> untuk membuka form titipan DSC baru.</p>
        <p>2. <span class='fw-bold text-danger'>Mandatory</span> Pilih POS lokasi titipan DSC ini diterima dari konsumen. <em class='text-danger'>Bila titipan sudah disimpan, POS tidak dapat dirubah.</em></p>
        <p>3. <span class='fw-bold text-danger'>Mandatory</span> Masukkan Tanggal Posing sebagai tanggal pembukuan secara keuangan / jurnal. <em>Idealnya tanggal ini ditentukan dari kapan Kasir menerima titipan tersebut.</em></p>
        <p>4. <span class='fw-bold text-danger'>Mandatory</span> Pilih Tipe titipan DSC. <em class='text-danger'>Untuk sekarang hanya terdapat 1 pilihan, yaitu DSC1.</em></p>
        <p class='text-nu'>5. Abaikan No Plutus, nomor ini akan otomatis dihasilkan oleh sistem, bedasarkan pilihan POS, Tahun dan Bulan Tanggal Posting dan Tipe titipan DSC.</p>
        <p>6. <span class='fw-bold text-danger'>Mandatory</span> Masukkan Tanggal Cetakan sebagai tanggal yang tertera pada cetakan TTS bila masih menggunakan cetakan TTS Manual. <em class='text-danger'>Idealnya tanggal ini ditentukan dari kapan Konsumen merasa memberikan titipan.</em></p>
        <p>7. Masukkan No Cetakan bila masih menggunakan cetakan TTS Manual.</p>
        <p>8. Masukkan No Referensi bila ada.</p>
        <p>9. <span class='fw-bold text-danger'>Mandatory</span> Masukkan Depositor dengan nama pihak yang memberikan titipan.</p>
        <p>10. <span class='fw-bold text-danger'>Mandatory</span> Pilih Metode dengan cara penerimaan titipan. Bila pilihan yang dicari tidak ada, silahkan menghubungi tim Accounting HO untuk dilakukan pensettingan opsi ini.</p>
        <p>11. <span class='fw-bold text-danger'>Mandatory</span> Masukkan Nominal dengan jumlah uang titipan yang diterima.</p>
        <p>12. <span class='fw-bold text-danger'>Mandatory</span> Masukkan Penjual dengan nama karyawan yang mempromosikan paket bundling DSC ini.</p>
        <p>13. <span class='fw-bold text-danger'>Mandatory</span> Pilih No Mesin yang sesuai dengan no mesin konsumen yang mengikuti program paket bundling DSC ini. Bila nomor mesin tidak ditemukan, silahkan menguhubungi tim IT Help Desk.</p>
        <p class='text-nu'>14. Abaikan No Rangka, nomor ini akan otomatis diisi oleh sistem, bedasarkan pilihan No Mesin. Gunakan informasi ini untuk melakukan cross cek validasi data.</p>
        <p class='text-nu'>15. Abaikan Tipe Kendaraan, tipe ini akan otomatis diisi oleh sistem, bedasarkan pilihan No Mesin. Gunakan informasi ini untuk melakukan cross cek validasi data</p>
        <p class='text-nu'>16. Abaikan Warna Kendaraan, warna ini akan otomatis diisi oleh sistem, bedasarkan pilihan No Mesin. Gunakan informasi ini untuk melakukan cross cek validasi data</p>
        <p class='text-nu'>17. Abaikan Tahun Rangka, tahun ini akan otomatis diisi oleh sistem, bedasarkan pilihan No Mesin. Gunakan informasi ini untuk melakukan cross cek validasi data</p>
        <p class='text-nu'>18. Abaikan Konsumen, nama ini akan otomatis diisi oleh sistem, bedasarkan pilihan No Mesin. Gunakan informasi ini untuk melakukan cross cek validasi data</p>
        <p>20. <span class='fw-bold text-danger'>Mandatory</span> Masukkan Keterangan dengan tambahan informasi perihal titipan DSC ini <em class='text-danger'>Maximal 500 karakter</em></p>
        <p>21. <span class='fw-bold text-danger'>Mandatory</span> Cek kembali kelengkapan data yang diisi dan dipilih sebelum menyimpan data.</p>
        <p>22. <span class='fw-bold text-danger'>Mandatory</span> Bila data sudah benar, silahkan klik tombol <button class="btn btn-sm btn-add"><i class="fa-solid fa-plus"></i> TAMBAH</button> untuk menyimpan data titipan.</p>
    </section>

    <br/>
    <section>
        <strong><i class="fa-solid fa-pencil"></i> Merubah Titipan DSC</strong>
        <p>
            Titipan hanya dapat dirubah saat status titipan adalah OS (Out Standing).
            Proses ini hanya dapat dilakan oleh User Login dengan akses Update (U) pada halaman titipan.
            Adapun data yang dapat dirubah adalah
        </p>
        <p>1. <span class='fw-bold text-danger'>Mandatory</span> Tanggal Posing.</p>
        <p>2. <span class='fw-bold text-danger'>Mandatory</span> Tipe titipan DSC.</p>
        <p>3. <span class='fw-bold text-danger'>Mandatory</span> Tanggal Cetakan.</p>
        <p>4. No Cetakan.</p>
        <p>5. No Referensi.</p>
        <p>6. <span class='fw-bold text-danger'>Mandatory</span> Depositor.</p>
        <p>7. <span class='fw-bold text-danger'>Mandatory</span> Metode.</p>
        <p>8. <span class='fw-bold text-danger'>Mandatory</span> Nominal.</p>
        <p>9. <span class='fw-bold text-danger'>Mandatory</span> Penjual .</p>
        <p>10. <span class='fw-bold text-danger'>Mandatory</span> No Mesin.</p>
        <p>11. <span class='fw-bold text-danger'>Mandatory</span> Keterangan</p>
        <p><span class='fw-bold'>POS tidak dapat dirubah, bila ditemukan pilihan POS ternyata adalah salah, rekomendasi dari IT adalah, me-non-aktif-kan titipan tersebut dan membuat ulang di POS yang sesuai.</span></p>
    </section>

    <br/>
    <section>
        <strong><i class="fa-solid fa-share"></i> Release Titipan DSC</strong>
        <p>
            Titipan hanya dapat di-release saat status titipan adalah <span class='text-os'>OS (Out Standing)</span>. Proses ini hanya dapat dilakan oleh User Login dengan akses Update (U) pada halaman titipan.
            Bila data titipan sudah benar, silahkan melakukan release titipan dengan menekan tombol <button class='btn btn-sm btn-outline-dark'><i class='fa fa-fw fa-solid fa-share'></i></button> di sebelah kiri dari titipan yang dimaksud untuk melanjutkan proses.
            Dengan melakukan proses ini, maka titipan akan berstatuskan <span class='text-rl'>RL (Release)</span> dengan sub status <span class='text-rl-wap'>WAP (Waiting Approval)</span>.
        </p>
    </section>

    <br/>
    <section>
        <strong><i class="fa-solid fa-reply"></i> UnRelease Titipan DSC</strong>
        <p>
            Titipan hanya dapat di-release saat status titipan adalah <span class='text-rl'>RL (Release)</span> dengan sub status <span class='text-rl-ap'>AP (Approved)</span>, <span class='text-rl-aap'>AAP (Auto-Approved)</span>, <span class='text-rl-wap'>WAP (Waiting Approval)</span> atau <span class='text-rl-dap'>DAP (Disapproved)</span>. Proses ini hanya dapat dilakan oleh User Login dengan akses Update (U) pada halaman titipan.Bila data titipan yang sudah release ternyata salah,
            silahkan melakukan un-release titipan dengan menekan tombol <button class='btn btn-sm btn-outline-dark'><i class='fa fa-fw fa-solid fa-reply'></i></button> di sebelah kiri dari titipan yang dimaksud.
            Dengan melakukan proses ini, maka titipan akan berstatuskan <span class='text-os'>OS (Out Standing)</span>.
        </p>
    </section>

    <br/>
    <section>
        <strong><i class="fa-solid fa-lock"></i> Posting Titipan DSC</strong>
        <p>
            Titipan hanya dapat di-posting saat status titipan adalah <span class='text-rl'>RL (Release)</span> dengan sub status <span class='text-rl-ap'>AP (Approved)</span> atau <span class='text-rl-aap'>AAP (Auto-Approved)</span>. Proses ini hanya dapat dilakan oleh User Login dengan akses Update (U) pada halaman titipan.
            Silahkan melakukan posting titipan dengan menekan tombol <button class='btn btn-sm btn-outline-dark'><i class='fa fa-fw fa-solid fa-lock'></i></button> di sebelah kiri dari titipan yang dimaksud.
            Dengan melakukan proses ini, maka titipan akan tercatat di pembukuan accounting dan titipan akan berstatuskan <span class='text-co fw-bold'>CO (Complete)</span>.
        </p>
    </section>

    <br/>
    <section>
        <strong><i class="fa-solid fa-times"></i> Batal Titipan DSC</strong>
        <p>
            Titipan hanya dapat dibatalkan saat status titipan adalah <span class='text-co fw-bold'>CO (Complete)</span>. Proses ini hanya dapat dilakan oleh User Login dengan akses Delete (D) pada halaman titipan.
            Silahkan melakukan pembatalkan titipan dengan menekan tombol <button class='btn btn-sm btn-outline-dark'><i class='fa fa-fw fa-solid fa-times'></i></button> di sebelah kiri dari titipan yang dimaksud.
            Dengan melakukan proses ini, maka akan terjadi pembukuan balik (jurnal balik) dan titipan akan berstatuskan <span class='text-x'>X (Cancel)</span>.
        </p>
    </section>

    <br/>
    <section>
        <strong><i class="fa-solid fa-trash"></i> Hapus Titipan DSC</strong>
        <p>
            Titipan hanya dapat dibatalkan saat status titipan adalah <span class='text-os'>OS (Out Standing)</span>. Proses ini hanya dapat dilakan oleh User Login dengan akses Delete (D) pada halaman titipan.
            Silahkan melakukan penghapusan titipan dengan menekan tombol <button class='btn btn-sm btn-outline-dark'><i class='fa fa-fw fa-solid fa-trash'></i></button> di sebelah kiri dari titipan yang dimaksud.
            Dengan melakukan proses ini, maka titipan akan berstatuskan <span class='text-nu'>NU (Not Used)</span>.
        </p>
    </section>
    <!-- [ApplicationUpdateContent].[Content] END-->
<!-- [ApplicationUpdateContent] END-->
