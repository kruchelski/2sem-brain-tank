ALTERADO
Tecnologia em Análise e Desenvolvimento de Sistemas

Setor de Educação Profissional e Tecnológica - SEPT

Universidade Federal do Paraná - UFPR

---

*DS120 - Desenvolvimento de Aplicações Web 1*

Prof. Alexander Robert Kutzke

**[Instruções para submissão de tarefas e trabalhos](http://gitlab.tadsufpr.net.br/ds120-alexkutzke/ds120-material-2017-2/blob/master/instrucoes_submissao_tarefas_e_trabalhos.md);**

# Especificação de Trabalho Prático

O trabalho prático envolve a criação de uma aplicação WEB completa. Ou seja,
que inclua a implementação de front-end, back-end e que possua integração com 
um banco de dados.

## Tema

O tema da aplicação a ser desenvolvida é livre. 

## Requisitos

A aplicação desenvolvida deve atender os seguintes requisitos:

 * **Front-end**:
  * Uso de HTML5, CSS3 e JS;
	* Interface amigável; ;
	* Validação de campos de formulário;
 * **Back-end**;
  * Integração com um banco de dados:
	  * Possuir, ao menos, duas tabelas com relacionamento entre si;
		* Modelagem consistente do banco de dados;
	* Criação, edição e remoção de itens do banco de dados;
	* Sistema de autenticação/autorização de usuário(s) salvo(s) em banco de dados;
  * Validação de campos de formulário e outras informações recebidas.

## Ambiente de Desenvolvimento

* O sistema deve ser desenvolvido utilizando **apenas** os recursos demonstrados
na disciplina DS120 (PHP, Javascript (JQuery), HTML5, CSS3 e algum banco de dados);
  * É permitido o uso de frameworks *front-end*, como Bootstrap e W3.CSS;
  * **Não** é permitido o uso de frameworks *back-end*.

## Entrega

O trabalho pode ser feito em **grupos de até 3 alunos**.

O sistema produzido deverá ser armazenado em um **repositório privado** na
plataforma Gitlab TADS (http://gitlab.tadsufpr.net.br). 

Para tanto, siga as instruções normais de submissão de trabalho da disciplina. Ou seja,
faça um fork desse repositório, salve-o em seu grupo, torne-o privado, 
adicione os colegas do seu grupo como
desenvolvedores do repositório e, finalmente, comece a editar os seus arquivos.

## Documentação

O repositório deverá conter um arquivo chamado `README.md` com a descrição
do sistema e de seu funcionamento. Deve-se utilizar a sintaxe correta da
linguagem **Markdown** nesse documento (para saber mais, consulte: https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet).

Em outras palavras, você deverá alterar exatamente este aquivo que está lendo agora.
Ou seja, pode apagar esse conteúdo sem problemas.

## Critério para avaliação

Os critérios para avaliação serão os seguintes:

 * **Defesa e conceitos** [4 pontos]:
    * Documentação e entrega pelo gitlab [1 ponto]; 
    * Organização do banco de dados [1 ponto];
    * Estrutura e clareza do código [1 ponto]
    * Qualidade da defesa e domínio do código [1 ponto];

 * **Funcionalidades e implementação** [6 pontos]:
   * Sistema de autenticação (login) [1 ponto];
   * Cadastro, alteração e remoção de informações no banco de dados [1 ponto];
   * Qualidade da interface do usuário [1 ponto];
   * Validação das informações de formulários e afins [1 ponto];
	 * Funcionamento da aplicação e qualidade da implementação [2 pontos];

## Defesa

O trabalho realizado deve ser defendido pelo grupo. A defesa consiste em
uma apresentação do sistema em funcionamento apenas ao professor da disciplina.
Nesse momento, o professor fará perguntas sobre a implementação da aplicação,
as quais devem ser respondidas por todos os integrantes do grupo.

A defesa do trabalho será realizada durante horário de aula, em data
a ser definida pelo professor.

## Sugestão de tema

Uma possível aplicação a ser desenvolvida é a seguinte:

> Um blog simples no qual um *usuário administrador* pode inserir novos *posts*. Todos
> os *posts* possuem uma data de criação e de atualização, as quais são exibidas
> aos leitores. Cada *post* pertence à uma *categoria* e pode possuir zero ou mais
> *comentários*. Leitores podem visualizar os *posts* existentes em uma *categoria* e
> fazer comentários nos *posts*. Para melhorar a qualidade do blog, os *posts* escritos
> pelo administrador podem receber tags HTML em seu conteúdo.
