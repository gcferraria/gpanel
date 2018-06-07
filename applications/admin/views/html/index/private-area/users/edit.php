<div class="tabbable tabbable-custom tabbable-full-width">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab_1" data-toggle="tab">Resumo</a>
        </li>
        <li class="">
            <a href="#tab_2" data-toggle="tab">Conta</a>
        </li>
    </ul>
    <div class="tab-content">
        <!-- Tab 1 -->
        <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-unstyled profile-nav">
                        <li>
                            <?php if( empty($user->object->avatar) ) : ?>
                            <img src="<?=base_url('img/default_avatar_big.jpg')?>" class="img-responsive" alt="" />
                            <?php else: ?>
                            <img src="<?=base_url('uploads/$user->object->avatar')?>" class="img-responsive" alt="" />
                            <?php endif ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 profile-info">
                            <h1><?=$user->object->name?></h1>
                            <ul class="list-inline">
                                <li>
                                    <i class="fa fa-user"></i> <a href="mailto:<?=$user->object->email?>"><?=$user->object->email?></a>
                                </li>
                                <li>
                                    <i class="fa fa-calendar"></i> <?=$user->object->creation_date?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tabbable tabbable-custom tabbable-custom-profile">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_11" data-toggle="tab">
                                    Funções
                                </a>
                            </li>
                            <li>
                                <a href="#tab_1_22" data-toggle="tab">
                                    Últimos Acessos
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1_11">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach( $user->roles as $role ) : ?>
                                            <tr>
                                                <td><?=$role->name?></td>
                                                <td>
                                                    <?=( $role->active_flag == 1 )
                                                    ? '<span class="label label-success">Activo</span>'
                                                    : '<span class="label label-danger">Inactivo</span>'?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_1_22">
                                <div class="tab-pane active" id="tab_1_1_1">
                                    <table class="table table-striped table-bordered table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>Endereço IP</th>
                                                <th>Sistema Operativo</th>
                                                <th>Browser</th>
                                                <th>Iniciado em</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach( $user->sessions as $session ) : ?>
                                            <tr>
                                                <td><?=$session->ip_address?></td>
                                                <td><?=$session->operating_system?></td>
                                                <td><?=$session->browser?></td>
                                                <td><?=$session->creation_date?></td>
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 2 -->
        <div class="tab-pane" id="tab_2">
            <div class="row profile-account">
                <div class="col-md-3">
                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                        <li class="active">
                            <a data-toggle="tab" href="#tab_1-1">
                                <i class="fa fa-cog"></i> Dados Pessoais
                            </a>
                            <span class="after"></span>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#tab_3-3">
                                <i class="fa fa-lock"></i> Alterar a Password
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div id="tab_1-1" class="tab-pane active">
                            <?=$user->personal_form?>
                        </div>
                        <div id="tab_3-3" class="tab-pane">
                            <?=$user->change_password_form?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>