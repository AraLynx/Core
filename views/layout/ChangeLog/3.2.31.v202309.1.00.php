<!-- [ApplicationUpdateContent] START-->
    <h5>
        <!-- [ApplicationUpdateContent].[Title] START-->
        Laporan Unit Stock
        <!-- [ApplicationUpdateContent].[Title] END-->
    </h5>
    <br/>
    <!-- [ApplicationUpdateContent].[Content] START-->
    <section>
        <p>
            Laporan ini bertujuan untuk menampilkan list data Unit yang pernah dan sedang menjadi stok kepemilikan cabang. Opsi tambahan pencarian yang disediakan adalah sebagai berikut
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
                        <td>Grup</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Grup Unit</td>
                    </tr>
                    <tr>
                        <td scope='row'>2</td>
                        <td>Tipe</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Tipe Unit. Pilihan tipe muncul bila pilihan Group dipilih.</td>
                    </tr>
                    <tr>
                        <td scope='row'>3</td>
                        <td>Warna</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Warna Unit.</td>
                    </tr>
                    <tr>
                        <td scope='row'>4</td>
                        <td>Status</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Status Unit. Pilihan status yang disediakan adalah
                            <br/><strong>Semua</strong>: menampilkan keseluruhan list unit, baik yang sudah terjual, retur, maupun yang masih menjadi stok
                            <br/><strong>Stok</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur
                            <br/><strong>Stok (Upload DO)</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur namun status & lokasinya adalah Upload DO
                            <br/><strong>Stok (Intransit)</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur namun sedang dalam proses pengiriman, atau berlokasi di luar Showroom maupun Gudang Unit
                            <br/><strong>Stok (On Hand)</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur yang berlokasi di dalam Showroom atau di dalam Gudang Unit
                            <br/><strong>Free</strong>: menampilkan keseluruhan list unit yang belum terjual, belum terbooking dan bukan unit retur
                            <br/><strong>Booked</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur namun sudah terbooking di SPK atau di UAC atau di UKAC
                            <br/><strong>Booked (SPK)</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur namun sudah terbooking di SPK
                            <br/><strong>Booked (Antar Cabang)</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur namun sudah terbooking di UAC atau di UKAC
                            <br/><strong>Booked (Antar Cabang - UAC)</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur namun sudah terbooking di UAC
                            <br/><strong>Booked (Antar Cabang - UKAC)</strong>: menampilkan keseluruhan list unit yang belum terjual dan bukan unit retur namun sudah terbooking di UKAC
                            <br/><strong>Terjual</strong>: menampilkan keseluruhan list unit yang sudah terjual baik via SPK atau UAC atau UKAC atau di data lama Accurate
                            <br/><strong>Terjual (SPK)</strong>: menampilkan keseluruhan list unit yang sudah terjual via SPK
                            <br/><strong>Terjual (Antar Cabang)</strong>: menampilkan keseluruhan list unit yang sudah terjual via UAC atau UKAC
                            <br/><strong>Terjual (Antar Cabang - UAC)</strong>: menampilkan keseluruhan list unit yang sudah terjual via UAC
                            <br/><strong>Terjual (Antar Cabang - UKAC)</strong>: menampilkan keseluruhan list unit yang sudah terjual via UKAC
                            <br/><strong>Terjual (Accurate)</strong>: menampilkan keseluruhan list unit yang sudah terjual di data lama Accurate
                        </td>
                    </tr>
                    <tr>
                        <td scope='row'>5</td>
                        <td>No Rangka</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan No Rangka Unit.</td>
                    </tr>
                    <tr>
                        <td scope='row'>6</td>
                        <td>No Mesin</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan No Mesin Unit.</td>
                    </tr>
                    <tr>
                        <td scope='row'>7</td>
                        <td>Tahun Rangka</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Tahun Rangka Unit.</td>
                    </tr>
                    <tr>
                        <td scope='row'>8</td>
                        <td>Umur min</td>
                        <td>Opsional</td>
                        <td>Untuk memfilter pencarian berdasarkan Umur Minimum unit dari tanggal DO.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <br/>
    <section>
        <h6>Hasil laporan</h6>
        <p>
            Hasil laporan dapat berupa tampilan list unit yang muncul pada tabel di bawah, maupun berupa file excel yang dapat di download.
            Untuk menampilkan list unit berdasarkan pencarian silahkan klik tombol <span class="btn btn-sm btn-primary"><i class="fa-solid fa-search"></i> CARI</span>.
            Sedangkan menampilkan langsung membuat file excel dan mendownload list unit berdasarkan pencarian silahkan klik tombol <span class="btn btn-sm btn-secondary align-middle">Export to Excel</span>.
        </p>
    </section>
    <!-- [ApplicationUpdateContent].[Content] END-->
<!-- [ApplicationUpdateContent] END-->
