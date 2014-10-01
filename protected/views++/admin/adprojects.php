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
<div id="pageTitle">
    <h2 class="thick-title page-title-bar">Projects List</h2>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="wrapper-box">
            <div class="wrapper-content">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">

                    </div>
                </div>
                <?php if (isset($models) && !empty($models) && count($models) > 0) { ?>
                    <div class="app-scrollable">
                        <table id="customers" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">Project Name</th>
                                    <th style="width: 15%;">User Name</th>
                                    <th style="width: 15%;">Email</th>
                                    <th style="width: 15%;">Mobile</th>
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
                                            <td><?php echo $models[$i]->user->tu_username; ?></td>
                                            <td><a href="mailto:<?php echo $models[$i]->user->tu_email; ?>"><?php echo $models[$i]->user->tu_email; ?></a></td>
                                            <td><a href="tel:<?php echo $models[$i]->user->tu_mobile; ?>"><?php echo $models[$i]->user->tu_mobile; ?></a></td>
                                            <td><?php echo $models[$i]->updated_at; ?></td>
                                            <td><img alter="collage" style="width:200px;height:150px;" class="cropper" src="<?php echo Yii::app()->request->baseUrl; ?>/finalimages/<?php echo $models[$i]->final_image_name; ?>"></td>
                                            <td><?php if ($models[$i]->mode == 0) echo "Dratf";
                                else echo "Submitted"; ?></td>
                                            <td class="text-right">
                                                <?php if ($models[$i]->mode == 1) { ?>
                                                    <a style="color:red;" target="_blank" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['ad_download_collage']) . '/?ukey=' . $models[$i]->ukey; ?>">Download</a>
                                                <?php } else { ?>
                                                    <a style="color:red;" target="_blank" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_collage']) . '/ukey=' . $models[$i]->ukey; ?>">Edit</a>
        <?php } ?>
                                            </td>
                                        </tr>
                                <?php } ?>
                                </tbody>
                        </table>
                    </div>
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