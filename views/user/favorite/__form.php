

<form action="" method="post" enctype="multipart/form-data">
<?= $form->input('name', 'Titre') ?>
<?= $form->input('slug', 'URL') ?>
<button type="submit" class="btn btn-primary">
    <?php if($category->getID() !== null):?>
        modifier
     <?php else:  ?>
            Ajouter
    <?php endif ?>
</button>
</form>