<?php
/* Smarty version 3.1.30, created on 2017-12-17 13:44:06
  from "F:\dernier uwamp 20 11\UwAmp\www\startbootstrap-bare-gh-pages\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a3674a6b96c35_61318666',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dfd76962826cae80c32c7e5d8d63bc8c4e1c7fe1' => 
    array (
      0 => 'F:\\dernier uwamp 20 11\\UwAmp\\www\\startbootstrap-bare-gh-pages\\templates\\index.tpl',
      1 => 1508774972,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a3674a6b96c35_61318666 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="container"> <p>
        
        <?php if ($_smarty_tpl->tpl_vars['is_connect']->value == TRUE) {?>
        <div class="alert alert-info" role="alert">
            Connecté en tant que <?php echo $_smarty_tpl->tpl_vars['nom_connect']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['prenom_connect']->value;?>
 
        </div>
    <?php }?>
    
    
    <?php if (isset($_smarty_tpl->tpl_vars['tab_session']->value['notification'])) {?>
   

    <div class="alert <?php echo $_smarty_tpl->tpl_vars['notification_result']->value;?>
 alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo $_smarty_tpl->tpl_vars['tab_session']->value['notification'];?>


    </div>
    
   <?php }?>
  
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">A Bootstrap 4 Starter Template</h1>  

            <p class="lead">Complete with pre-defined file paths and responsive navigation!</p>
            <ul class="list-unstyled">
                <li>Bootstrap 4.0.0-beta</li>
                <li>jQuery 3.2.1</li>
            </ul>

        </div>
    </div>
    
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tab_articles']->value, 'value');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['value']->value) {
?>
    <h2>
        <div class="card col-md" >
            <img class="card-img-top" src="img/<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['value']->value['titre'];?>
">
            <div class="card-body">
                <h4 class="card-title"><?php echo $_smarty_tpl->tpl_vars['value']->value['titre'];?>
</h4>
                <p class="card-text"><?php echo $_smarty_tpl->tpl_vars['value']->value['texte'];?>
</p>
                <a href="#" class="btn btn-primary">Crée le : <?php echo $_smarty_tpl->tpl_vars['value']->value['date_fr'];?>
</a>
                <a href="article.php?action=modifier&id_article=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" class="btn btn-warning">Modifier l'article</a>
            </div>
        </div>
        
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    </h2>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
             
            <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['nb_pages']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['nb_pages']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
            <li class="page-item <?php if ($_smarty_tpl->tpl_vars['page_courante']->value == $_smarty_tpl->tpl_vars['i']->value) {?> active <?php }?>">
                <a class="page-link" href="?page=<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</a></li>
             
            <?php }
}
?>

        </ul>
    </nav>
</div>

<!-- Bootstrap core JavaScript -->
<?php echo '<script'; ?>
 src="vendor/jquery/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="vendor/popper/popper.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="vendor/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>

<?php }
}
