<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption font-green-sharp uppercase">
                        <i class="icon-user font-green-sharp"></i> Dados de Perfil
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab" aria-expanded="true" class="uppercase">Dados Pessoais</a>
                        </li>
                        <li class="">
                            <a href="#tab_1_2" data-toggle="tab" aria-expanded="false" class="uppercase">Alterar Password</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <?=$profile->personal_form?>                                                      
                        </div>
                        <div class="tab-pane" id="tab_1_2">
                            <?=$profile->change_password_form?>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>