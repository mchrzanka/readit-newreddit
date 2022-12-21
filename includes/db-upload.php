<?php
$imageData = '';
if (isset($_FILES['file']['name'][0])) {
    foreach ($_FILES['file']['name'] as $keys => $values) {
        $fileName = uniqid() . '_' . $_FILES['file']['name'][$keys];
        if (move_uploaded_file($_FILES['file']['tmp_name'][$keys], 'mchrzanowski1.dmitstudent.ca/dmit2503/new-readit/images/uploads/' . $fileName)) {
            $imageData .= '<img src="mchrzanowski1.dmitstudent.ca/dmit2503/new-readit/images/uploads/' . $fileName . '" class="thumbnail" />';
        }
    }
}
//echo $imageData;
