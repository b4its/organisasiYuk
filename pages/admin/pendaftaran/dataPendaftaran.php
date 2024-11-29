<div class="content-wrapper">
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title">Data Pendaftaran Organisasi</h4>
                    </div>



                  <div class="table-responsive mt-4">
                  <?php
                        include_once('../../database/connection.php');
                        $sql = "SELECT * FROM pendaftaranorganisasi";
                        $i = 1;
                        if ($hasilQuery = mysqli_query($db, $sql)) {
                            if (mysqli_num_rows($hasilQuery) > 0) {
                                ?>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>User</th>
                          <th>Nama</th>
                          <th>Alasan</th>
                          <th>Organisasi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                                while ($kolom = mysqli_fetch_array($hasilQuery)) {

                        ?>
                                <tr>
                                    <td><?php echo $i++ ?></td>
                                    <td>
                                        <?php 
                                    $sqlUser = "SELECT username FROM users where idUser ='".$kolom['user']."'";
                                    if ($queryUsers = mysqli_query($db, $sqlUser)) {
                                        if (mysqli_num_rows($queryUsers) > 0) {
                                            while ($user = mysqli_fetch_array($queryUsers)) {
                                                echo $user['username'];
                                            }
                                        }
                                    }

                                            ?>
                                    </td>
                                    <td><?php echo $kolom['nama']?></td>
                                    <td><?php echo $kolom['alasan']?></td>
                                    <td>
                                        <?php 
                                    $sqlOrganisasii = "SELECT namaOrganisasi FROM organisasi where idOrganisasi ='".$kolom['organisasi']."'";
                                    if ($queryOrganisasi = mysqli_query($db, $sqlOrganisasii)) {
                                        if (mysqli_num_rows($queryOrganisasi) > 0) {
                                            while ($organisasi = mysqli_fetch_array($queryOrganisasi)) {
                                                echo $organisasi['namaOrganisasi'];
                                            }
                                        }
                                    }

                                            ?>
                                    </td>
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
                        <form action="organisasi/proses/prosesUpdateOrganisasi.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <p>Nama</p>
                                <input type="text"class="form-control" name="nama" placeholder="masukkan nama organisasi.." value="<?php echo $kolom['namaOrganisasi']?>"><br>
                                <p>Deskripsi</p>
                                <input type="text" class="form-control" name="deskripsi" placeholder="masukkan deskripsi.." value="<?php echo $kolom['deskripsi'] ?>"><br>
                                <p>Jenis</p>
                                <input type="text" class="form-control" name="jenis" placeholder="masukkan jenis.." value="<?php echo $kolom['jenis']?>"><br>
                                <p>Foto</p>
                                <input type="file" class="form-control" name="imageFile"><br>
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