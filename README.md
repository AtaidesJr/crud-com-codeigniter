
## INSTALAÇÃO

Clonar repositorio do github e instalar 
`composer create-project codeigniter4/appstarter` 


## BASE DE DADOS 

Foi utilizador o MYSQL , em `.env` e possivél observar as config do banco 
necessario tem uma base de dados com o nome `ordem` já criado , para em seguida realizar a importação das tabelas!!

## MUDANÇA IMPORTANTE DO INDEX.PHP

`index.php` não está mais na raiz do projeto! Ele foi movido para dentro da pasta *public*,
para melhor segurança e separação dos componentes.

## USUÁRIO & INFORMAÇÕES

Utilizar e-mail : juniorferreira020@gmail.com
E senha : 123456 , para acessar aplicação 

Crud simples onde será 
possível criar , editar e excluir usuários 
Também é possível atribuir permissões de grupo com isso gerenciando o que pode ser acessado
Pelo usuario , cuja tenha a permissão atribuída!
Gerenciamento de rotas e padrão de segurança para criptografia de senhas , 
sessão de usuários e rota para recuperação de senha através link no e-mail!
