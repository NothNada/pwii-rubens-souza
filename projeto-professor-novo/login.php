<?php
session_start();
require 'db.php';

// o $_SERVER["REQUEST_METHOD"] serve para ver como o usuario está se conectando
// se for POST, então ele quer enviar informação e receberx
// se não, ele vai retornar o html de login 
if($_SERVER["REQUEST_METHOD"]=="POST"){

    // aqui pego os parametros para o cadastro ou login
    $user  = $_POST["user"] ?? '';
    $pass  = $_POST["pass"] ?? '';
    $email = $_POST["email"] ?? '';
    $cpf   = $_POST["cpf"] ?? '';
    
    
    //verifica se não está vazio
    if(empty($user) || empty($pass) || empty($email) || empty($cpf)){
        die(json_encode(['error' => true, 'msg' => 'fax as coisas puta q pariu']));
    }
    
    // faz uma verificação simples, para saber se não tem caracteres estranhos
    if(preg_match('/\s/', $pass) || preg_match('/\s/', $user)){
        die(json_encode(['error' => true, 'msg' => 'Pelo amor de Deus escreve direito']));
    }
    
    if(mb_strlen($pass, 'UTF-8') > 20 || mb_strlen($user, 'UTF-8') > 100 || mb_strlen($email, 'UTF-8') > 100 || mb_strlen($cpf, 'UTF-8') > 20){
        die(json_encode(['error' => true, 'msg' => 'Pelo amor de Deus, não coloque muita coisa, tá chato em']));
    }
    
    try{

        // vamos fazer uma verificação, se retornar algum valor, significa que tem um usuario com o email
        // e se tiver fazemos o login
        // senão fazemos o cadastro
        $stmt = $pdo->prepare("SELECT * from usuarios where email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario){
            // aqui fazemos uma verificação de senha, porque quando salvamos, salvamos como um hash criptografado
            // que é bem mais seguro
            if(password_verify($pass, $usuario['senha'])){

                // colocamos as propriedades no $_SESSION do usuario
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_nome'] = $usuario['nome'];
                $_SESSION['user_email'] = $usuario['email'];

                die(json_encode(['error'=>false, 'msg' => "Usuario logado com sucesso!"]));
            }

            // nunca dizer se a senha ou usuario está incorreta, isso facilita para invasores tentar brute-force
            die(json_encode(['error' => true, 'msg' => 'Alguma coisa está incorreta!']));
        }

        // aqui faço a criptografia da senha
        $senhaHash = password_hash($pass, PASSWORD_DEFAULT);

        // aqui preparo a inserção dos dados
        $stmt = $pdo->prepare("insert into usuarios (nome, cpf, senha, email) values (?, ?, ?, ?)");

        // aqui eu ezecuto, a diferença do execute para o fetch, é
        // o execute ele não retorna nenhum dado, apenas ezecuta
        // já o fetch ele retorna dados, simples
        $stmt->execute([$user, $cpf, $senhaHash, $email]);

        
    } catch (PDOException $e){
        die(json_encode(['error' => true, 'msg' => $e->getMessage()]));
    }
    
    
}

if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

?>

<!-- aqui a parte do front end -->
<!-- 

Confesso que usei IA no front-end

-->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }

        input:focus {
            border-color: #667eea;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #777;
            font-size: 18px;
        }

        .toggle-password:hover {
            color: #333;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .success-message {
            color: #2ecc71;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .loading {
            display: none;
            text-align: center;
            margin-top: 15px;
        }

        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #667eea;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro & Login</h1>
        <form id="authForm">
            <div class="form-group">
                <label for="user">Nome</label>
                <input type="text" id="user" name="user" placeholder="Digite seu nome" required>
                <div class="error-message" id="user-error"></div>
            </div>
            
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required maxlength="14">
                <div class="error-message" id="cpf-error"></div>
            </div>
            
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                <div class="error-message" id="email-error"></div>
            </div>
            
            <div class="form-group">
                <label for="pass">Senha</label>
                <div class="password-container">
                    <input type="password" id="pass" name="pass" placeholder="Digite sua senha" required>
                    <button type="button" class="toggle-password" id="togglePassword">👁️</button>
                </div>
                <div class="error-message" id="pass-error"></div>
            </div>
            
            <button type="submit" class="btn-submit">Enviar</button>
            
            <div class="loading" id="loading">
                <div class="loading-spinner"></div>
                <p>Processando...</p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('authForm');
            const cpfInput = document.getElementById('cpf');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('pass');
            const loadingElement = document.getElementById('loading');
            
            // Formatação do CPF
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }
                
                // Aplica a formatação
                if (value.length <= 11) {
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                }
                
                e.target.value = value;
            });
            
            // Alternar visibilidade da senha
            togglePasswordBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePasswordBtn.textContent = type === 'password' ? '👁️' : '🔒';
            });
            
            // Validação do formulário
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Resetar mensagens de erro
                document.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                // Validar campos
                let isValid = true;
                const user = document.getElementById('user').value.trim();
                const cpf = document.getElementById('cpf').value.trim();
                const email = document.getElementById('email').value.trim();
                const pass = document.getElementById('pass').value;
                
                // Validar nome
                if (user.length === 0) {
                    showError('user-error', 'Por favor, digite seu nome');
                    isValid = false;
                } else if (user.length > 100) {
                    showError('user-error', 'O nome deve ter no máximo 100 caracteres');
                    isValid = false;
                }
                
                // Validar CPF
                if (cpf.length === 0) {
                    showError('cpf-error', 'Por favor, digite seu CPF');
                    isValid = false;
                } else if (cpf.length < 14) {
                    showError('cpf-error', 'CPF incompleto');
                    isValid = false;
                }
                
                // Validar email
                if (email.length === 0) {
                    showError('email-error', 'Por favor, digite seu e-mail');
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    showError('email-error', 'Por favor, digite um e-mail válido');
                    isValid = false;
                } else if (email.length > 100) {
                    showError('email-error', 'O e-mail deve ter no máximo 100 caracteres');
                    isValid = false;
                }
                
                // Validar senha
                if (pass.length === 0) {
                    showError('pass-error', 'Por favor, digite sua senha');
                    isValid = false;
                } else if (pass.length > 20) {
                    showError('pass-error', 'A senha deve ter no máximo 20 caracteres');
                    isValid = false;
                } else if (/\s/.test(pass)) {
                    showError('pass-error', 'A senha não pode conter espaços');
                    isValid = false;
                }
                
                if (isValid) {
                    // Mostrar loading
                    loadingElement.style.display = 'block';
                    
                    // Enviar dados via fetch
                    fetch('login.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            user: user,
                            cpf: cpf,
                            email: email,
                            pass: pass
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Esconder loading
                        loadingElement.style.display = 'none';
                        
                        if (data.error) {
                            // Mostrar alerta de erro
                            showAlert('error', data.msg);
                        } else {
                            // Mostrar alerta de sucesso
                            showAlert('success', data.msg);
                            
                            // Se for login bem-sucedido, redirecionar após 2 segundos
                            if (!data.error) {
                                setTimeout(() => {
                                    window.location.href = 'index.php';
                                }, 2000);
                            }
                        }
                    })
                    .catch(error => {
                        // Esconder loading
                        loadingElement.style.display = 'none';
                        
                        console.error('Erro:', error);
                        showAlert('error', 'Erro de conexão. Tente novamente.');
                    });
                }
            });
            
            // Função para validar e-mail
            function isValidEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
            
            // Função para mostrar mensagens de erro
            function showError(elementId, message) {
                const errorElement = document.getElementById(elementId);
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
            
            // Função para mostrar alertas
            function showAlert(type, message) {
                // Remover alertas anteriores
                const existingAlerts = document.querySelectorAll('.custom-alert');
                existingAlerts.forEach(alert => alert.remove());
                
                // Criar elemento de alerta
                const alert = document.createElement('div');
                alert.className = `custom-alert ${type}`;
                alert.textContent = message;
                
                // Estilizar o alerta
                alert.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 15px 20px;
                    border-radius: 8px;
                    color: white;
                    font-weight: 500;
                    z-index: 1000;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                    max-width: 400px;
                    animation: slideIn 0.3s ease-out;
                `;
                
                if (type === 'error') {
                    alert.style.background = 'linear-gradient(135deg, #e74c3c, #c0392b)';
                } else {
                    alert.style.background = 'linear-gradient(135deg, #2ecc71, #27ae60)';
                }
                
                // Adicionar ao documento
                document.body.appendChild(alert);
                
                // Remover após 5 segundos
                setTimeout(() => {
                    alert.style.animation = 'slideOut 0.3s ease-in';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 300);
                }, 5000);
                
                // Adicionar estilos de animação
                if (!document.querySelector('#alert-styles')) {
                    const style = document.createElement('style');
                    style.id = 'alert-styles';
                    style.textContent = `
                        @keyframes slideIn {
                            from { transform: translateX(100%); opacity: 0; }
                            to { transform: translateX(0); opacity: 1; }
                        }
                        @keyframes slideOut {
                            from { transform: translateX(0); opacity: 1; }
                            to { transform: translateX(100%); opacity: 0; }
                        }
                    `;
                    document.head.appendChild(style);
                }
            }
        });
    </script>
</body>
</html>