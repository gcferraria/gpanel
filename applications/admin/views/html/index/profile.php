<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption font-green-sharp uppercase">
                        <i class="icon-user font-green-sharp"></i> Actividade
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab" aria-expanded="true" class="uppercase">Últimos Conteúdos</a>
                        </li>
                        <li class="">
                            <a href="#tab_1_2" data-toggle="tab" aria-expanded="false" class="uppercase">Últimos Acessos</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <table class="table table-striped table-bordered table-hover">
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
                        <div class="tab-pane" id="tab_1_2">
                            <table class="table table-striped table-bordered table-hover">
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