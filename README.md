# agro

Criar um arquivo para acesso ao banco de dados

Deve se chamar "config.ini" e estar na raiz do projeto

Exemplo de arquivo:

```ini
; Main section that contains the access to the database
[main]
server = localhost
user = root
pass = 
database = agro
```

`estrutura.sql` - contém a estrutura do banco  
`dados.sql`     - contém alguns dados preenchidos do banco

As senhas dos usuários estão criptografadas no banco, portanto, para editar a senha de um usuário já existe, deve-se atualizar o usuário com o método próprio para isso (ver arquivo Update.class.php)


