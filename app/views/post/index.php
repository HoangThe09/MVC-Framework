<!DOCTYPE html>
<html lang="en">

<head>
    <base href="http://localhost:8181/">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>

<body>
    <div class="content">
        <div class="main">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form_input">
                            <h2 class="form_heading text-center">Tạo bài viết</h2>
                            <form method="post">
                                <div class="row mb-3">
                                    <label for="inputUrl" class="col-sm-2 col-form-label">URL</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="text" class="form-control" id="inputUrl" placeholder="URL">
                                        <button class="btn btn-outline-secondary" type="button" id="btn-search">Search</button>
                                    </div>
                                </div>
                                <div class="submit-button text-center">
                                    <button type="button" disabled id="btn-save" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1"></div>
                    <div class="col-lg-3 col-md-3">
                        <div class="news__preview"></div>
                    </div>
                </div>
                <h2 class="form_heading border-bottom">List</h2>
                <div class="row news__list">
                    <?php include_once 'list.php' ?>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="./js/main.js"></script>
</body>

</html>