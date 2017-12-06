<div class="row">
    <div class="col-md-4 col-md-offset-1"><img id='pencil' style="width:80%;" src="images/<?=$contact->contact_img?>" class="img-circle">
       <!-- <span style='margin-left:5%;'>IMAGE:</span><button style='margin-left:2%;' type='button' id='pencil' class='btn btn-default' name='img'>	
    <span  class='glyphicon glyphicon-pencil'></span></button>-->
        <form action="#" method="POST" enctype="multipart/form-data">
            <input id='skriven' type='file' name='image_updt' placeholder='Update'>
            <button id='dugme' type='submit' class='btn btn-success' name='update_image'>Update</button>
        </form>
    
    </div>
</div>

<div id="row" class="row">
    <div class="col-md-6 col-md-offset-5">

        <table class="table table-success" id="tabela">
            <thead>
                <tr>
                    <th class="contact_name">
                        <?= ucwords($contact->first_name).' '.ucwords($contact->last_name) ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Phone</th>
                    <td>
                        <?= $data[0]->data;?>
                    </td>
                    <td><button type='button' id='pencil0' class='btn btn-default' name='pencil_0'>
                    <span  class='glyphicon glyphicon-pencil'></span>
                </button>
                        <input id='skriven0' type='text' name='update_0' placeholder='Update Phone No' autofocus>
                        <button id='dugme0' type='submit' class='update btn btn-success' name='subbmit_0' data-pk="<?= $contact->id ?>" data-cdtype="0">Update</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>
                        <?= $data[1]->data;?>
                    </td>
                    <td><button type='button' id='pencil1' class='btn btn-default' name='pencil_1'>	
                    <span  class='glyphicon glyphicon-pencil'></span>
                </button>
                        <input id='skriven1' type='text' name='update_1' placeholder='Update Email' autofocus>
                        <button id='dugme1' type='submit' class='update btn btn-success' name='subbmit_1' data-pk="<?= $contact->id ?>" data-cdtype="1">Update</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>
                        <?= $data[2]->data;?>
                    </td>
                    <td><button type='button' id='pencil2' class='btn btn-default' name='pencil_2'>	
                    <span  class='glyphicon glyphicon-pencil'></span>
                </button>
                        <input id='skriven2' type='text' name='update_2' placeholder='Update Address' autofocus>
                        <button id='dugme2' type='submit' class='update btn btn-success' name='subbmit_2' data-pk="<?= $contact->id ?>" data-cdtype="2">Update</button>
                    </td>
                </tr>
            </tbody>
        </table>


    </div>
    <button id='del' type='submit' data-pk='<?= $contact->id ?>'>
            <span>Del</span>
        </button>
</div>

<script>
    //ajax for delete contact from db & image from folder
    $(document).on('click', '#del', function(e) {
        e.preventDefault();

        if (confirm('Are you shure you want to delete this contact?!')) {
            var id = $(this).data('pk');
            $.ajax({
                url: 'index.php?r=site/delete',
                type: 'post',
                data: {
                    id: id
                },
                success: function() {
                    location.href = 'index.php?r=site/addressbook';
                },
                error: function() {
                    alert('Error deleting contact');
                }
            })
        }
    })



    //ajax for update  contact data
    $(document).on('click', '.update', function(e) {
        e.preventDefault();
        var id = $(this).data('pk');
        var cdtype = $(this).data('cdtype');
        var str = '#skriven' + String(cdtype);
        var value = $(str).val();
        $.ajax({
            url: 'index.php?r=site/update',
            type: 'post',
            data: {
                id: id,
                cdtype: cdtype,
                value: value
            },
            success: function() {
                window.location.reload();
            },
            error: function() {
                alert('Error deleting contact');
            }
        })

    })

</script>
