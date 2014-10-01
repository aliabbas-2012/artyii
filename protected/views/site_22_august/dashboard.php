<style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 1em;
    border: 1px solid #CCC;
    padding: 3px 7px 2px 7px;
}

#customers th {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #e0005f;
    color: #ffffff;
}

#customers tr.alt td {
    color: #000000;
    background-color: #e0005f;
}
</style>
<div id="gameSection" style="padding-top:0px;">
    <div style="background: white;min-height: 400px;text-align: center;">

        <div id="pageTitle">
            <h2 class="thick-title page-title-bar">Projects List</h2>
        </div>
        <div class="row" >
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="wrapper-box">
                    <div class="wrapper-content">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">

                            </div>
                        </div>
                        <?php if (isset($models) && !empty($models) && count($models) > 0) { ?>
                          
                                <table id="customers" class="table table-bordered" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">Project Name</th>
                                            <th style="width: 15%;">Last Updated</th>
                                            <th style="width: 15%;">Collage</th>
                                            <th style="width: 15%;">Status</th>
                                            <th style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 0; $i < count($models); $i++) { ?>
                                            <tr>
                                                <td><?php echo $models[$i]->name; ?></td>
                                                <td><?php echo $models[$i]->updated_at; ?></td>
                                                <td height="100">
                                                    
                                                    <?php if(!empty($models[$i]->final_image_name)){?>
                                                    
                                                    <img alter="collage" style="width:150px;height:80px;" class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/finalimages/<?php echo $models[$i]->final_image_name; ?>">
                                                    <?php } 
                                                    else echo "Not Ready"; ?>
                                                
                                                </td>
                                                <td><?php if($models[$i]->mode==0) echo "Draft";else echo "Submitted"; ?></td>
                                                <td class="text-right">
                                                    <?php if($models[$i]->mode==1){?>
                                                        <a style="color:red;" target="_blank" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_download_collage']) . '/?ukey=' . $models[$i]->ukey; ?>">Download |</a>
                                                    <?php } else {?>
                                                        <a style="color:red;" target="_blank" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_upload_project_img']) . '/?ukey=' . $models[$i]->ukey; ?>">Edit |</a>
                                                    <?php } ?>
                                                        <a style="color:red;" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_delete_project']) . '/?ukey=' . $models[$i]->ukey; ?>">Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            
                        <?php } ?>
                        <div style="margin-top:20px;">

                            <?php
                            $this->widget('CLinkPager', array(
                                'pages' => $pages,
                            ))
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>