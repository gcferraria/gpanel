<div data-jsb-name="assets" data-jsb-type="context" data-jsb-class="JsB">
    
    <form method="post" action="/media/modal.json" data-jsb-type="context" data-jsb-class="App.Modal.Assets.Form">
        <input type="hidden" name="page"   value="1"  data-jsb-class="Input" />
        <input type="hidden" name="offset" value="36" data-jsb-class="Input" />

        <div class="row" data-jsb-name="fields" data-jsb-class="JsB">
            <div class="col-md-3" data-jsb-name="orderBy" data-jsb-class="JsB">
               <select name="orderBy" class="form-control" placeholder="<?=$this->lang->line('sort_by')?>" data-jsb-name="field" data-jsb-class="App.Modal.Assets.Form.Select">
                    <option></option>
                    <option value="filename"><?=$this->lang->line('file_filename')?></option>
                    <option value="filetype"><?=$this->lang->line('file_filetype')?></option>
                    <option value="extension"><?=$this->lang->line('file_extension')?></option>
                    <option value="filesize"><?=$this->lang->line('file_filesize')?></option>
                    <option value="creation_date"><?=$this->lang->line('file_creation_date')?></option>
                </select>
            </div>
            <div class="col-md-2" data-jsb-name="orderDir" data-jsb-class="JsB">
               <select name="orderDir" class="form-control" placeholder="<?=$this->lang->line('sort_direction')?>" data-jsb-name="field" data-jsb-class="App.Modal.Assets.Form.Select">
                    <option></option>
                    <option value="asc"><?=$this->lang->line('sort_asc')?></option>
                    <option value="desc"><?=$this->lang->line('sort_desc')?></option>
                </select>
            </div>
            <div class="col-md-7">
                <div class="input-group" data-jsb-name="search" data-jsb-class="JsB">
                    <input  
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="<?=$this->lang->line('search')?>" 
                        data-jsb-name="field" 
                        data-jsb-class="Input" 
                    />
                    <span class="input-group-btn">
                        <button type="submit" class="btn green" data-jsb-class="App.Modal.Assets.Form.Search">
                            <i class="fa fa-search"></i>
                        </button>
                        <button type="submit" class="btn btn-default" data-jsb-class="App.Modal.Assets.Form.Clear">
                            <i class="fa fa-times"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </form>

    <div class="row margin-top-20">
        <div class="col-md-12">
            <div>
                <ul class="thumbsview clearfix" data-jsb-name="results" data-jsb-class="App.Modal.Assets.Results">
                    <li class="template" data-jsb-name="media-item" data-jsb-class="JsB">
                        <div class="element">
                            <div class="elementthumb thumbnail">
                                <a href="#" class="file" data-jsb-name="link" data-jsb-class="App.Modal.Assets.Results.Item">
                                    <img src="" alt="" class="img-responsive" data-jsb-name="image" data-jsb-class="JsB" />
                                </a>
                            </div>
                            <div class="label">
                                <span class="title" data-jsb-name="title" data-jsb-class="JsB"></span>
                            </div>
                            <div class="label size">
                                <span class="size"  data-jsb-name="size"  data-jsb-class="JsB"></span>
                            </div>
                        </div>
                    </li>
                    <li data-jsb-name="warning" data-jsb-class="JsB" class="note note-warning template"></li>
                </ul>
                <div class="load">
                    <button 
                        type="button"
                        data-jsb-name="more" 
                        data-jsb-class="App.Modal.Assets.Results.More" 
                        data-loading-text="Loading..." 
                        class="btn red btn-circle">
                        <span class="ladda-label"><?=$this->lang->line('view_more')?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>