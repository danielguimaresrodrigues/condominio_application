<header class="py-4 mb-3 border-bottom bg-white" id="topo_menu">
    <div class="toggle border-bottom" onclick="toggleMenu();"></div>
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
        <div class="logo">
            <a href="#"><img class="img-fluid" src="../assets/img/Symbol-Gestorr-horizontal.svg" style="width: 8vw; height: auto;"></a>
            </ul>
        </div>

        <div class="d-flex align-items-center">
            <div class="w-100 my-auto">

            </div>
            <div class="flex-shrink-0 dropdown" id="drop">
                <a href="#" class="d-block link-dark text-decoration-none mt-3 me-4" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Notificações">
                        <i class="bi bi-bell text-secondary fs-3 position-relative">
                            <p class="text-center count" style="font-size: 1rem;"><span class="position-absolute top-0 start-100 translate-middle badge bg-danger mt-1">
                                    9</span></p>
                        </i>
                    </span>
                </a>
                <ul class="dropdown-menu text-small shadow overflow-auto" style="width: 350px; height: 80vh" aria-labelledby="dropdownUser2">

                </ul>
            </div>
            <div class="flex-shrink-0 dropdown">

                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php echo $_SESSION['nome']; ?>">
                        <?php if (is_null($_SESSION['foto'])) { ?>
                            <i class="bi bi-person-circle"></i>
                        <?php } else { ?>
                            <img class="rounded-circle border border-secondary" width="32" height="32" src="../assets/avatars/<?php echo $_SESSION['foto']; ?>">
                        <?php } ?>
                    </span>
                </a>

                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="../cadastros/personaldata"><i class="bi bi-person-gear my-auto text-secondary me-3" style="font-size: 1.5rem;"></i>Meus Dados</a></li>
                    <li><a class="dropdown-item" href="../cadastros/accountpasswordchange"><i class="bi bi-key my-auto text-secondary me-3" style="font-size: 1.5rem;"></i>Alterar Senha</a></li>
                    <?php
                    if ($_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1' || $_SESSION['perfil'] === '2') :
                    ?>
                        <li><a class="dropdown-item" href="../cadastros/dados-do-condominio"><i class="bi bi-building-fill-gear my-auto text-secondary me-3" style="font-size: 1.2rem;"></i>Condomínio</a></li>
                    <?php endif; ?>
                    <?php
                    if ($_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1') :
                    ?>
                        <li><a class="dropdown-item" href="../cadastros/gerenciamento-de-usuarios"><i class="bi bi-people my-auto text-secondary me-3" style="font-size: 1.5rem;"></i>Usuários</a></li>
                    <?php endif; ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../db/sair.php"><i class="bi bi-box-arrow-right my-auto text-secondary me-3" style="font-size: 1.2rem;"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="navigation border-end no_print">
    <!--div class="toggle border-end" onclick="toggleMenu();"></div-->
    <ul>
        <li class="list border-bottom">
            <a href="">
                <span class="icon-hamb"><i class="bi bi-chevron-compact-right my-auto text-secondary" style="font-size: 1.2rem;"></i></span>
                <span class="title-user"><?php echo $_SESSION['nome']; ?></span>
            </a>
        </li>
        <li class="list active">
            <a href="../dashboards/painel">
                <span class="icon"><i class="bi bi-columns-gap my-auto text-secondary" style="font-size: 1.2rem;"></i></span>
                <span class="title">Painel</span>
            </a>
        </li>
        <li class="list">
            <a href="../cadastros/personaldata">
                <span class="icon"><i class="bi bi-person-gear my-auto text-secondary" style="font-size: 1.6rem;"></i></span>
                <span class="title">Meus Dados</span>
            </a>
        </li>
        <li class="list">
            <a href="../cadastros/quadro-de-avisos">
                <span class="icon"><i class="bi bi-columns my-auto text-secondary" style="font-size: 1.5rem;"></i></span>
                <span class="title">Quadro de Avisos</span>
            </a>
        </li>
        <li class="list">
            <a href="">
                <span class="icon"><i class="bi bi-coin my-auto text-secondary" style="font-size: 1.8rem;"></i></span>
                <span class="title">Prestação de Contas</span>
            </a>
        </li>
        <li class="list">
            <a href="">
                <span class="icon"><i class="bi bi-paperclip my-auto text-secondary" style="font-size: 1.6rem;"></i></span>
                <span class="title">Documentos</span>
            </a>
        </li>
        <li class="list">
            <a href="../cadastros/arrecadacoes">
                <span class="icon"><i class="bi bi-cash-coin my-auto text-secondary" style="font-size: 1.5rem;"></i></span>
                <span class="title">Financeiro</span>
            </a>
        </li>
        <li class="list">
            <a href="">
                <span class="icon"><i class="bi bi-telephone my-auto text-secondary" style="font-size: 1.5rem;"></i></span>
                <span class="title">Telefones Úteis</span>
            </a>
        </li>
        <?php
        if ($_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1' || $_SESSION['perfil'] === '2') :
        ?>
            <li class="list">
                <a href="../cadastros/dados-do-condominio">
                    <span class="icon"><i class="bi bi-building-fill-gear my-auto text-secondary" style="font-size: 1.5rem;"></i></span>
                    <span class="title">Condomínio</span>
                </a>
            </li>
        <?php endif; ?>
        <li class="list">
            <a href="../db/sair.php">
                <span class="icon"><i class="bi bi-box-arrow-right my-auto text-secondary" style="font-size: 1.5rem;"></i></span>
                <span class="title">Sair</span>
            </a>
        </li>
    </ul>
</div>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fs-5 fw-light">Redefinição de senha</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="container my-5" id="email" align="center">
                    <div class="col-12">
                        <form action="../edits/alterasenha.php" method="POST" id="staticform" onsubmit="return validarPost()">
                            <div class="form-group mb-3 text-start">
                                <label for="nome">E-mail</label>
                                <input class="form-control" type="email" value="<?php echo $_SESSION['nome']; ?>" name="emaill" id="emaill" placeholder="Digite o e-mail cadastrado" required readonly>
                            </div>
                            <div class="form-group mb-3 text-start">
                                <label for="nome">Senha atual</label>
                                <input class="form-control" type="password" name="senhaatual" id="senhaatual" placeholder="Digite senha atual" required>
                            </div>
                            <div class="form-group mb-3 text-start">
                                <label for="nome">Nova senha</label>
                                <input class="form-control" type="password" name="novasenha" id="novasenha" placeholder="Digite a nova senha" required>
                            </div>
                            <div class="form-group mb-3 text-start">
                                <label for="nome">Confirmar nova senha</label>
                                <input class="form-control" type="password" name="senha" id="senha" placeholder="Confirme a nova senha" required>
                            </div>
                            <div class="g-recaptcha mb-3" data-sitekey="6LeDPB8gAAAAAKeMkKe3FK6ZB6nGfSdxydvu51bE"></div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-outline-primary rounded-3" id="bt-salvar">Salvar</button>
                            </div>
                            <div class="alert alert-danger d-none">
                                Preencha o campo <span id="campo-erro"></span>!
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
</script>

<script>
    const list = document.querySelectorAll('.list');

    function activeLink() {
        list.forEach((item) => item.classList.remove('active'));
        this.classList.add('active');
    }
    list.forEach((item) =>
        item.addEventListener('click', activeLink));
</script>

<script type="text/javascript">
    function toggleMenu() {
        let navigation = document.querySelector('.navigation');
        let toggle = document.querySelector('.toggle');
        navigation.classList.toggle('active');
        toggle.classList.toggle('active');
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#cpf").mask("000.000.000-00")
        $("#cnpj").mask("00.000.000/0000-00")
        $("#celular").mask("(00) 00000-0000")
        $("#moeda").mask("999.999.990,00", {
            reverse: true
        })
        $("#valor_edits").mask("999.999.990,00", {
            reverse: true
        })
        $("#valor_adds_group").mask("999.999.990,00", {
            reverse: true
        })
        $("#valor").mask("999.999.990,00", {
            reverse: true
        })
        $("#moeda").mask("999.999.990,00", {
            reverse: true
        })
        //cep_edit
        $("#cep").mask("00.000-000")
        $("#cep_edit").mask("00.000-000")
        $("#dataNascimento").mask("00/00/0000")

        $("#rg").mask("999.999.999-W", {
            translation: {
                'W': {
                    pattern: /[X0-9]/
                }
            },
            reverse: true
        })

        var options = {
            translation: {
                'A': {
                    pattern: /[A-Z]/
                },
                'a': {
                    pattern: /[a-zA-Z]/
                },
                'S': {
                    pattern: /[a-zA-Z0-9]/
                },
                'L': {
                    pattern: /[a-z]/
                },
            }
        }

        $("#placa").mask("AAA-0000", options)

        $("#codigo").mask("AA.LLL.0000", options)

        $("#celular").mask("(00) 00000-0009")

        $("#celular").blur(function(event) {
            if ($(this).val().length == 15) {
                $("#celular").mask("(00) 00000-0009")
            } else {
                $("#celular").mask("(00) 00000-0009")
            }
        })
    })
</script>

<script>
    $(document).ready(function() {

        id = document.getElementById("emaill").val;

        $.ajax({
            url: "../consultas/fetch.php",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('#drop').html(data);

            }
        });

    })
</script>