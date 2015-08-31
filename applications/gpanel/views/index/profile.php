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
                            <?php if( empty($profile->administrator->avatar) ) : ?>
                            <img src="<?=base_url('images/default_avatar_big.jpg')?>" class="img-responsive" alt="" />
                            <?php else: ?>
                            <img src="<?=base_url('uploads/$this->administrator->avatar')?>" class="img-responsive" alt="" />
                            <?php endif ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-8 profile-info">
                            <h1><?=$profile->administrator->name?></h1>
                            <p><a href="mailto:<?=$profile->administrator->email?>"><?=$profile->administrator->email?></a></p>
                            <ul class="list-inline">
                                <li>
                                    <i class="fa <?=( $profile->administrator->sex == 'M') ? 'fa-male' : 'female'?>"></i> <?=( $profile->administrator->sex == 'M') ? 'Masculino' : 'Feminino'?>
                                </li>
                                <li>
                                    <i class="fa fa-calendar"></i> <?=$profile->administrator->creation_date?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="portlet sale-summary">
                                <div class="portlet-title">
                                    <div class="caption">
                                        Estatisticas
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <ul class="list-unstyled">
                                        <li>
                                            <span class="sale-info">Total de Conteúdos Criados</span>
                                            <span class="sale-num"><?=$profile->total_contents?></span>
                                        </li>
                                        <li>
                                            <span class="sale-info">Total de Categorias Criadas</span>
                                            <span class="sale-num"><?=$profile->total_categories?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabbable tabbable-custom tabbable-custom-profile">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_11" data-toggle="tab">
                                    Últimos Conteúdos
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
                                                <th>Publicado em</th>
                                                <th>Estado</th>
                                                <th>Categorias</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach( $profile->contents as $content ) : ?>
                                            <tr>
                                                <td><?=$content->name?></td>
                                                <td><?=$content->publish_date?></td>
                                                <td>
                                                    <?=( $content->publish == 1 )
                                                    ? '<span class="label label-success">Publicado</span>'
                                                    : '<span class="label label-danger">Inactivo</span>'?>
                                                </td>
                                                <td>
                                                    <?php foreach( $content->categories as $category ) : ?>
                                                    <a class="btn default btn-xs blue-stripe" href="<?=$category->link?>">
                                                        <?=$category->name?>
                                                    </a>
                                                    <?php endforeach ?>
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
                                            <?php foreach( $profile->sessions as $session ) : ?>
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
                            <?=$profile->personal_form?>
                        </div>
                        <div id="tab_3-3" class="tab-pane">
                             <?=$profile->change_password_form?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>