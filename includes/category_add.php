<script type="text/javascript">
    /* <![CDATA[ */
    $('#editAlert').hide();
    jQuery(function () {
        jQuery("#name").validate({
            expression: "if (VAL) return true; else return false;",
            message: "menu name is Mandatory."
        });
        jQuery('.AdvancedForm').validated(function () {
            alert("Use this call to make AJAX submissions.");
        });
    });
    /* ]]> */
    function categoryDeleteProduct(id) {

        if (confirm('Are you sure to delete ?')) {
            window.location = '?manager=category_add&id=' + id;
        }


    }

    function editCategory(id, name, description) {

        $('#idss').val(id);
        $('#namessss').val(name);
        $('#descriptions').val(description);
        $('#editPopCategory').modal('show');
    }

</script>
<?php
if (isset($_GET['id'])) {
//        $p = $_GET['id'];

    $delId = $_GET['id'];

    $mess = $mydb->deleteQuery('tbl_category', 'id=' . $delId);

    $url = ADMINURLPATH . "category_add&?id=" . $id . "&code=1&message=" . $mess;
    $mydb->redirect($url);
}

?>
<?php

include("classes/category.class.php");
include("classes/createthumbnail.php");
$parentId = $_GET['p'];
if (isset($_POST['btnadd'])) {
    //print_r($_FILES);
    $data = "";
    if ($_POST['name'] != "") {
        $data['name'] = $_POST['name'];
        $data['description'] = $_POST['description'];

        $data['urlcode'] = $mydb->clean4urlcode(trim($_POST['name']));

        $cid = $mydb->insertQuery('tbl_category', $data);

        $url = ADMINURLPATH . "category_add&message=New category Added successfully.&code=1";
        $mydb->redirect($url);
    } else {
        echo '<div class="alert-danger">Please insert value</div>';
    }

}
if (isset($_POST['btnupdate'])) {
    $data = "";

    $id = $_POST['id'];
    $data['name'] = $_POST['name'];
    $data['description'] = $_POST['description'];

    $mess = $mydb->updateQuery('tbl_category', $data, 'id=' . $id);
    $url = ADMINURLPATH . "category_add&code=1&message=" . $mess;
    $mydb->redirect($url);
}

?>
<?php
if (isset($_GET['message'])) { ?>

    <div id="editAlert">
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <span id="showMsg"><?php echo $_GET['message']; ?></span>
        </div>
    </div>
    <script>

        setTimeout(function () {
            $("#editAlert").fadeOut(1500);
        }, 3000);

    </script>
<?php }
?>
<div class="col-md-6">
    <form name="form1" method="post" action="" enctype="multipart/form-data" id="mainform">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" id="id-form">

            <tr>
                <th width="15%">Name:</th>
                <td><input type="text" name="name" id="name"
                           class="inp-form"/></td>
            </tr>
            <tr>
                <th valign="top">Description:</th>
                <td><textarea name="description" id="description" cols="" rows="" class="form-textarea"></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input name="btnadd" type="submit" value="Add" class="button" onMouseOut="this.className='button'"
                           onMouseOver="this.className='button'"/></td>
            </tr>
        </table>
    </form>
</div>
<div class="col-md-6">

    <table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table" class="product-table">
        <tr class="no-hover">


            <th class="table-header-repeat line-left minwidth-1">Name:</th>
            <th class="table-header-repeat line-left minwidth-1">Description:</th>
            <th class="table-header-repeat line-left minwidth-1">Option:</th>
        </tr>
        <?php
        $result = $mydb->getQuery('*', 'tbl_category');
        while ($row = mysql_fetch_array($result)) {
            $id = $row['id'];
            ?>
            <tr>
                <td>
                    <?php echo $row['name']; ?>
                </td>
                <td>
                    <?php echo $row['description']; ?>
                </td>
                <td>

                    <button
                        title="Edit" class="btn-com info-tooltip"
                        onclick="editCategory( '<?php echo $row['id']; ?>','<?php echo $row['name']; ?>','<?php echo $row['description']; ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="javascript:void(0);" title="Delete" class="info-tooltip btn-com"
                       onclick="categoryDeleteProduct('<?php echo $row['id']; ?>')">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>

            <?php
        } ?>
    </table>

</div>


<div class="modal fade" id="editPopCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Edit Category</h4>

            </div>
            <div class="modal-body">

                <form name="form1" method="post" action="">
                    <table width="100%">

                        <tr>

                            <td><input type="hidden" name="id" id="idss"
                                /></td>
                        </tr>
                        <tr>
                            <th width="15%">Name:</th>
                            <td><input type="text" name="name" id="namessss"
                                /></td>
                        </tr>
                        <tr>
                            <th valign="top">Description:</th>
                            <td><textarea name="description" id="descriptions" cols="" rows=""
                                          class="form-textarea"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input name="btnupdate" type="submit" value="Update" class="button"
                                       onMouseOut="this.className='button'" onMouseOver="this.className='button'"/></td>
                        </tr>
                    </table>
                </form>


            </div>
            <!-- <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">sale</button>
             </div>-->
        </div>
    </div>

</div>