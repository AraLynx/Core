<!-- [ApplicationUpdateContent] START-->
    <div>
        <h5>
            <!-- [ApplicationUpdateContent].[Title] START-->
            This page has migrated from TDE 1.0
            <!-- [ApplicationUpdateContent].[Title] END-->
        </h5>
        <br/>
        <!-- [ApplicationUpdateContent].[Content] START-->
        <p>
            Halaman <a href='/TDE/Gaia/aftersales/dhtmaster'>Master Daihatsu</a> pada applikasi <a href='/TDE/Gaia'>Gaia</a> modul <a href='/TDE/Gaia/aftersales'>After Sales</a> sudah tersedia di TDE 2.0.
            Halaman ini adalah halaman gabungan dari beberapa halaman master dari <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6'>TDE 1.0 After Sales</a>.
            Adapun halaman-halaman yang dimigrasi adalah
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=47'>Master Customer & Vehicle</a>,
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=48'>Master Vendor Jasa & Sparepart</a>,
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=44'>Master Service</a>,
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=43'>Master Warehouse</a>,
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=45'>Master Sparepart</a>,
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=47'>Master Customer & Vehicle</a>,
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=62'>POS Configuration</a>,
            <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=60'>Special Authorization</a>,
            dan <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=53'>Terms & Condition</a>
        </p>
    </div>
    <br/>
    <div>
        <h5>
            <img class="subpage_menu_icon" src="/TDE/Gaia/resources/images/subpage/dashboard.png"></img> Dashboard
        </h5>
        <p>
            Halaman ini dibuat untuk menampung semua hal yang perlu dipantau menjadi 1 halaman secara bersamaan, untuk memudahkan dalam mengambil keputusan.
            Silahkan ajukan ide / pendapat ke tim IT Development (email : it.development@tmsgroup.co.id) untuk membahas pengembangan yang diinginkan.
        </p>

        <br/><p class='fw-bold'>New Astra's Group & Type</p>
        <p>
            Tabel ini berisikan pengelompokkan group dan tipe kendaraan berdasarkan data Pembelian Unit dari divisi Showroom yang belum disetting relasinya terhadap Model dan Tipe kendaraan berdasarkan pengelompokkan divisi After Sales - Workshop.
            Tujuan dari tampilan tabel ini adalah, memberikan akses dengan cepat untuk merelasikan antara Group dan Tipe diisi Showroom dengan Model dan Tipe divisi After Sales, sehingga semua unit hasil penjualan dari divisi Showroom (SPK) ter-mapping dengan baik dengan
            Luxury Group after sales. Dengan demikian, setiap data unit yang sudah ter-mapping akan otomatis menjadi data kendaraan konsumen di divisi After Sales dengan Flat Rate yang sesuai.
            <br/><em class='text-danger'>Harap memantau list data ini secara mingguan, pastikan list ini kosong sehingga data penjualan Unit Showroom tersinkron sempurna dengan data Kendaraan Konsumen After Sales.</em>
        </p>
    </div>
    <br/>
    <div>
        <h5>
            <img class="subpage_menu_icon" src="/TDE/Gaia/resources/images/subpage/flat-rate.png"></img> Flat Rate
        </h5>
        <p>
            <strong>Halaman ini adalah migrasi dari halaman <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=44'>TDE 1.0 Master Service</a>, sub panel Luxury Factor.</strong>
            <br/>Opsi pencarian yang disediakan adalah sebagai berikut
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
                        <td>Luxury Group</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Nama Luxury Group</td>
                    </tr>
                    <tr>
                        <td scope='row'>2</td>
                        <td>Status</td>
                        <td><span class='fw-bold text-danger'>Mandatory, deafult : All</span></td>
                        <td>Untuk memfilter pencarian berdasarkan Status</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br/><h6>Tambah Flat Rate</h6>
        <p>
            Untuk menambah Luxury Group yang baru, silahkan menekan tombol <span class="btn btn-sm btn-add"><i class="fa-solid fa-plus"></i> ADD</span> disebelah tombol <span class="btn btn-sm btn-search"><i class="fa-solid fa-search"></i> SEARCH</span>
            untuk mengakses menu Add Luxury Group.
        </p>
        <br/><h6>Edit Flat Rate</h6>
        <p>
            Setiap baris pada hasil pencarian adalah 1 Luxury Group. Di baris ini terdapat keterangan Harge Flat Rate dan Nama Luxury Group. Untuk merubah Harga Flat Rate, Nama Luxury Group, dan Status
            silahkan menekan tombol <span class="btn btn-sm btn-outline-dark" title="View"><i class="fa-fw fa-solid fa-eye"></i></span> untuk mengakses menu Edit Luxury Group.

            <br/><br/>Di setiap baris Luxury Group, terdapat sub tabel yang menunjukkan Merk, Model dan Tipe kendaraan yang menggunakan konfirugarsi Luxury Group tersebut.
            Sub table ini dapat dibuka dengan menekan tombol <a class='k-icon k-i-expand'></a> pada kolom paling kiri dari baris Luxury Group.

            <br/><br/>Untuk memindahkan secara cepat Merek, Model dan Tipe kendaraan yang tidak sesuai dengan pengelompokkan Luxury Groupnya, silahkan menekan tombol
            <span class="btn btn-sm btn-outline-dark" title="Change Luxury Group"><i class="fa-fw fa-solid fa-rotate"></i></span> untuk mengakses menu Change Luxury Group.
        </p>
    </div>
    <br/>
    <div>
        <h5>
            <img class="subpage_menu_icon" src="/TDE/Gaia/resources/images/subpage/classification.png"></img> Vehicle Model & Type
        </h5>
        <p>
            <strong>Halaman ini adalah migrasi dari halaman <a href='https://vibi.trimandirigroup.com:5431/gaia/main.php?department=6&module=47'>TDE 1.0 Master Customer</a>, sub panel Master menu Brand, Model & Type.</strong>
            <br/>Opsi pencarian yang disediakan adalah sebagai berikut
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
                        <td>Brand</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Nama Merk</td>
                    </tr>
                    <tr>
                        <td scope='row'>2</td>
                        <td>Model</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Nama Model</td>
                    </tr>
                    <tr>
                        <td scope='row'>3</td>
                        <td>Type</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Nama Tipe</td>
                    </tr>
                    <tr>
                        <td scope='row'>4</td>
                        <td>Luxury Group</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Luxury Group</td>
                    </tr>
                    <tr>
                        <td scope='row'>2</td>
                        <td>Status</td>
                        <td><span class='fw-bold text-danger'>Mandatory, deafult : All</span></td>
                        <td>Untuk memfilter pencarian berdasarkan Status</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br/><h6>Tambah Brand, Model dan Tipe</h6>
        <p>
            Untuk menambah Tipe baru, silahkan menekan tombol <span class="btn btn-sm btn-add"><i class="fa-solid fa-plus"></i> ADD</span> disebelah tombol <span class="btn btn-sm btn-search"><i class="fa-solid fa-search"></i> SEARCH</span>
            untuk mengakses menu Add Model & Type.
            Bila tidak ditemukan Merk atau Model yang dicari silahkan menggunakan akses cepat tombol <span class="btn btn-sm btn-add" title="Add Brand"><i class="fa-solid fa-plus"></i> Brand</span> atau <span class="btn btn-sm btn-add" title="Add Model"><i class="fa-solid fa-plus"></i> Model</span>
            untuk menambah Merk atau Model baru pada list pilihan.
        </p>
        <br/><h6>Edit Brand, Model dan Tipe</h6>
        <p>
            Setiap baris pada hasil pencarian adalah 1 Kombinasi Merk, Model dan Tipe. Di baris ini terdapat keterangan Merk, Model, Tipe, Kode, CC, Engine Pattern, Luxury Group, Flat Rate dan Jumlah data kendaraan konsumen yang menggunakan data ini.
            Untuk merubah data ini silahkan menekan tombol <span class="btn btn-sm btn-outline-dark" title="View"><i class="fa-fw fa-solid fa-eye"></i></span> untuk mengakses menu Edit Model & Type.
            Bila tidak ditemukan Merk atau Model yang dicari silahkan menggunakan akses cepat tombol <span class="btn btn-sm btn-add" title="Add Brand"><i class="fa-solid fa-plus"></i> Brand</span> atau <span class="btn btn-sm btn-add" title="Add Model"><i class="fa-solid fa-plus"></i> Model</span>
            untuk menambah Merk atau Model baru pada list pilihan.

            <br/><br/>Di setiap baris Model dan Tipe ini, terdapat sub tabel yang menunjukkan Merk, Grup dan Tipe kendaraan berdasarkan pengelompokkan kendaraan divisi Showroom yang menggunakan konfirugarsi Model & Type tersebut.
            Sub table ini dapat dibuka dengan menekan tombol <a class='k-icon k-i-expand'></a> pada kolom paling kiri dari baris Model & Type.

            <br/><br/>Untuk memindahkan secara cepat Merek, Grup dan Tipe kendaraan divisi Showroom yang tidak sesuai dengan pengelompokkan Model dan Tipe, silahkan menekan tombol
            <span class="btn btn-sm btn-outline-dark" title="Change Model & Type"><i class="fa-fw fa-solid fa-rotate"></i></span> untuk mengakses menu Change Model & Group.
        </p>
    </div>
<!-- [ApplicationUpdateContent] END-->
