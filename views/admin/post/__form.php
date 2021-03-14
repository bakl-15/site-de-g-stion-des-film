

<form action="" method="post" enctype="multipart/form-data">
<?= $form->input('titre', 'Titre') ?>
<?= $form->input('slug', 'URL') ?>
<?= $form->input('auteur', 'Auteur') ?>

<?php if($post->getAffiche()) :?>
  
 <img src="/uploads/post/<?= $post->getAffiche()?>" alt="" srcset=""  style="width:250px"> 
<?php endif ?>
<?= $form->file('affiche', 'Image à la une') ?>
<?=$form->select('categories_ids', 'Catégories', $categories)?>
<?= $form->textArea('description', 'Déscription'); ?> 
<?= $form->input('dateCreation', 'Date de création') ?>
<?= $form->input('dateSortir', 'Date de sortie') ?>
<?= $form->input('dateModification', 'Date de modification') ?>
<button type="submit" class="btn btn-primary">
    <?php if($post->getID() !== null):?>
        modifier
     <?php else:  ?>
            Ajouter
    <?php endif ?>
</button>
</form>