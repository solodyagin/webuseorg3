<?php

// Данный код создан и распространяется по лицензии GPL v3
// Изначальный автор данного кода - Грибов Павел
// http://грибовы.рф

if (($user->mode==1) or ($user->mode==0)){
?>
<div class="container-fluid">
<div class="row-fluid">   
    <ul class="nav nav-tabs" id="myTab">
      <li><a href="#plc" data-toggle="tab">Помещение</a></li>
      <li><a href="#mto" data-toggle="tab">Ответственность</a></li>
    </ul>
    <div class="row-fluid">
        <div class="col-xs-2 col-md-2 col-sm-2">    
                <div id="photoid" name="photoid" align="center"><img src=controller/client/themes/<?php echo $cfg->theme;?>/img/noimage.jpg width=200></div>                
                <input name=geteqid TYPE='hidden' id=geteqid value="">                      
        </div>
        <div class="col-xs-10 col-md-10 col-sm-10">    
            <table id="list2"></table><div id="pager2"></div>
        </div>            
    </div>    
    <table id="tbl_move"></table><div id="pager4"></div>
</div>
</div>    
<script type="text/javascript" src="controller/client/js/eq_list.js"></script>   
<?php
}
 else {
?>
<div class="alert alert-error">
  У вас нет доступа в данный раздел!
</div>
<?php
    
}

?>