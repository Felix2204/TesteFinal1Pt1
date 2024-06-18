<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="revel.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="revel.js"></script>
</head>
<body>
<section  class="h-100 gradient-form" style="background-color: #272727;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <i  class="bi bi-bell-fill" style="font: size 20px;"></i>
                  <h1 class="mt-1 mb-5 pb-1">ServiceBell</h1>
                </div>
               
                <div style="text-align: center; font-size: 24px; font-weight: bold; line-height: 1.3;">
                   
                    <h2 class="tracking-tight md:text-2xl">
                         <em>Cadastro</em>
                    </h2>
                </div>
                <form  method = "post" data-parsley-validate  action="verify/setado.php ">
                  <div data-mdb-input-init class="form-outline mb-4"> 
                    <label class="form-label "for="nome">Usuário</label>
                    <input type="text" name="login" id="user" class="form-control" placeholder="Nome" required>
                   
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4 position-relative" >
                    <label  class="form-label" for="password">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control" required>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button value = "entrar" name="submit" type="submit"  class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"data-mdb-button-init data-mdb-ripple-init>Cadastrar</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Já tem uma conta?</p>
                    <a href="login.php" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-dark"> Entrar</a> 
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">Como Funciona o ServiceBell</h4>
                <p class="small mb-0">O ServiceBell é um sistema de cadastro e contratação de serviços rapido e facil, 
                  agilizando o contato do trabalhador com o cliente
                  por meio de informações visiveis aos usuários, proporcionando uma experiência de usuário intuitiva e eficiente.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <script src="./node_modules/jquery/dist/jquery.js"></script>
    <script src="./node_modules/parsleyjs/dist/parsley.min.js"></script>
    <link rel="stylesheet" href="node_modules/parsleyjs/src/parsley.css">
    <script src="./node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
    
</body>
</html>