<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container px-5 ">

        <div class="row justify-content-sm-center">

            <div class="col-lg-6 col-sm-12 px-5 mt-2">
                <div class="card px-5 mt-4">
                    <div class="card-body">
                        <form>
                            <div class="container d-flex my-3">
                                <div class="d-flex justify-content-center align-items-center w-100">
                                    <h5 class="mb-3">Registro</h5>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="" required>
                                    </div>

                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="apellido" class="form-label">Apellido</label>
                                        <input type="text" name="apellido" class="form-control" id="apellido" required>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="run" class="form-label">RUN</label>
                                    <input type="text" name="run" maxlength="9" size="9" class="form-control mr-5" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="inputEmail4" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="inputEmail4" required>
                            </div>

                            <div class="col-12">
                                <label for="inputPassword4" class="form-label">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" required>
                            </div>




                            <div class="col-12 d-flex justify-content-center mb-2 mt-4"> 
                                <button type="submit" class="btn btn-dark">Registrarse</button>
                            </div>
                        </form>
                    </div>
                </div>



            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>