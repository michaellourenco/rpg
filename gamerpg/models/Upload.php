
<?php

$form = new Zend_Form();
$form->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

$image = new Zend_Form_Element_File('image');
$image->setLabel('Upload an image:')
      ->setDestination($config->paths->upload)
      ->setRequired(true)
      ->setMaxFileSize(10240000) // limits the filesize on the client side
      ->setDescription('Click Browse and click on the image file you would like to upload');
$image->addValidator('Count', false, 1);                // ensure only 1 file
$image->addValidator('Size', false, 10240000);            // limit to 10 meg
$image->addValidator('Extension', false, 'jpg,jpeg,png,gif');// only JPEG, PNG, and GIFs

$form->addElement($image);

$this->view->form = $form;

if($this->getRequest()->isPost())
{
    if(!$form->isValid($this->getRequest()->getParams()))
    {
        return $this->render('add');
    }

    if(!$form->image->receive())
    {
        $this->view->message = '<div class="popup-warning">Errors Receiving File.</div>';
        return $this->render('add');
    }

    if($form->image->isUploaded())
    {
        $values = $form->getValues();
        $source = $form->image->getFileName();

        //to re-name the image, all you need to do is save it with a new name, instead of the name they uploaded it with. Normally, I use the primary key of the database row where I'm storing the name of the image. For example, if it's an image of Person 1, I call it 1.jpg. The important thing is that you make sure the image name will be unique in whatever directory you save it to.

        $new_image_name = 'someNameYouInvent';

        //save image to database and filesystem here
        $image_saved = move_uploaded_file($source, '/www/yourdx/images/'.$new_image_name);
        if($image_saved)
        {
            $this->view->image = '<img src="/images/'.$new_image_name.'" />';
            $form->reset();//only do this if it saved ok and you want to re-display the fresh empty form
        }
    }
}
