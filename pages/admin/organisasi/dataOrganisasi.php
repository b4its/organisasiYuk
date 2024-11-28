<div class="content-wrapper">
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title">Data Organisasi</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalorganisasi">Tambahkan Organisasi</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalorganisasi" tabindex="-1" role="dialog" aria-labelledby="modalorganisasiLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalorganisasiLabel">Tambahkan Organisasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="organisasi/proses/prosesTambahkanOrganisasi.php" method="post">
                            <div class="modal-body">
                                <p>Nama</p>
                                <input type="text"class="form-control" name="nama" placeholder="masukkan nama organisasi.."><br>
                                <p>Deskripsi</p>
                                <input type="text" class="form-control" name="deskripsi" placeholder="masukkan deskripsi.."><br>
                                <p>Jenis</p>
                                <input type="text" class="form-control" name="jenis" placeholder="masukkan jenis.."><br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary fw-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambahkan</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- end modal -->


                  <div class="table-responsive mt-4">
                  <?php
                        include_once('../../database/connection.php');
                        $sql = "SELECT * FROM organisasi";
                        $i = 1;
                        if ($hasilQuery = mysqli_query($db, $sql)) {
                            if (mysqli_num_rows($hasilQuery) > 0) {
                                ?>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Organisasi</th>
                          <th>Deskripsi</th>
                          <th>Jenis</th>
                          <th>Foto</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                                while ($kolom = mysqli_fetch_array($hasilQuery)) {
                        ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td><?php echo $kolom['namaOrganisasi']?></td>
                                    <td><?php echo $kolom['deskripsi']?></td>
                                    <td><?php echo $kolom['jenis']?></td>
                                    <td><?php echo $kolom['foto']?></td>
                                    <td>
                                    <div class="d-flex flex-row" style="gap:0.5em">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalUpdate<?php echo $kolom['idOrganisasi']?>">Edit</button>
                                        <a href="organisasi/proses/prosesDeleteOrganisasi.php?id=<?php echo $kolom['idOrganisasi'] ?>" class="btn btn-danger">Hapus</a></td>
                                    </div>    
                                </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="modalUpdate<?php echo $kolom['idOrganisasi']?>" tabindex="-1" role="dialog" aria-labelledby="modalorganisasiLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalorganisasiLabel">Update Organisasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="organisasi/proses/prosesUpdateOrganisasi.php" method="post">
                            <div class="modal-body">
                                <p>Nama</p>
                                <input type="text"class="form-control" name="nama" placeholder="masukkan nama organisasi.." value="<?php echo $kolom['namaOrganisasi']?>"><br>
                                <p>Deskripsi</p>
                                <input type="text" class="form-control" name="deskripsi" placeholder="masukkan deskripsi.." value="<?php echo $kolom['deskripsi'] ?>"><br>
                                <p>Jenis</p>
                                <input type="text" class="form-control" name="jenis" placeholder="masukkan jenis.." value="<?php echo $kolom['jenis']?>"><br>
                                <input type="number" name="idOrganisasi" value="<?php echo $kolom['idOrganisasi']?>" hidden>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary fw-bold" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- end modal -->
                        <?php
                                }
                            }else {
                                echo "<p>Saat ini tidak ada organisasi</p>";
                            }
                        }
?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

</div>