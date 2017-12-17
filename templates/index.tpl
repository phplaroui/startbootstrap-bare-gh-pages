<div class="container"> <p>
        
        {if $is_connect == TRUE}
        <div class="alert alert-info" role="alert">
            Connecté en tant que {$nom_connect} {$prenom_connect} 
        </div>
    {/if}
    
    
    {if isset($tab_session['notification'])}
   

    <div class="alert {$notification_result} alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {$tab_session['notification']}

    </div>
    
   {/if}
  
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
    
    {foreach from =$tab_articles item=value}
    <h2>
        <div class="card col-md" >
            <img class="card-img-top" src="img/{$value['id']}.jpg" alt="{$value['titre']}">
            <div class="card-body">
                <h4 class="card-title">{$value['titre']}</h4>
                <p class="card-text">{$value['texte']}</p>
                <a href="#" class="btn btn-primary">Crée le : {$value['date_fr']}</a>
                <a href="article.php?action=modifier&id_article={$value['id']}" class="btn btn-warning">Modifier l'article</a>
            </div>
        </div>
        
        {/foreach}
    </h2>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
             
            {for $i=1 to $nb_pages}
            <li class="page-item {if $page_courante == $i} active {/if}">
                <a class="page-link" href="?page={$i}">{$i}</a></li>
             
            {/for}
        </ul>
    </nav>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

