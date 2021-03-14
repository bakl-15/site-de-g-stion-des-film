

<form action="" method="post" enctype="multipart/form-data" class="bg-light">
       <?= $form->input('username', 'Nom d\'utilisateur') ?>
       <?= $form->input('password', 'Mot de passe') ?>
       <?= $form->input('confirm', 'Confirmer Mot de passe') ?>
       <?= $form->input('email', 'Email') ?>
       
       <?= $form->selectSimple('genre', 'Genre',['Homme', 'Femme']) ?>
       <?= $form->input('dateNaissance', 'Date de naissance') ?>
       <?= $form->input('dateCreation', 'Date de création') ?>
       <?= $form->input('dateModification', 'Date de modification') ?>
       <?= $form->checkbox('cgu', 'CGU') ?>
       <button type="submit" class="btn btn-primary">
           <?php if($user->getID() !== null):?>
               modifier
            <?php else:  ?>
                   Ajouter
           <?php endif ?>
       </button>
</form>