
<?php $this->layout('loyout', ['title' => 'Security']) ?>
<main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-lock'></i> Безопасность
            </h1>
        </div>
    <div class="state">
        <?php echo $state?>
    </div>
        <form action="" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Обновление пароля</h2>
                            </div>
                            <div class="panel-content">
                                <!-- email -->
                                <!-- password -->
                                <?php if(isset($_SESSION['role']['1']) != 'ADMIN'):?>
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Старый пароль</label>
                                        <input name="oldPassword" "password" id="simpleinput" class="form-control">
                                    </div>
                                <?php endif;?>

                                <!-- password confirmation-->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Новый пароль</label>
                                    <input name="newPassword" type="password" id="simpleinput" class="form-control">
                                </div>


                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Изменить</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </main>

