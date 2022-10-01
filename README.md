### Mapeador de dados - (Data mapper)

Um mapeador de dados é uma camada de acesso à dados que realiza transferências bidirecionais de dados entre um armazenamento de dados persistente (frequentemente um banco de dados relacional) e uma representação em memória dos dados (a camada de domínio). O objetivo do padrão é manter a representação em memória e o armazenamento de dados persistente independente um do outro e do próprio mapeador de dados. A camada é composta de um ou mais mapeadores (ou Objetos de Acesso à Dados - Data Access Objects), realizando a tranferência dos dados. Implementações de mapeadores variam em escopo. Mapeadores genéricos irão manipular muitos tipos de entidades de domínio diferentes e mapeadores dedicados irão manipular um ou alguns.

[Referência](https://designpatternsphp.readthedocs.io/pt_BR/latest/Structural/DataMapper/README.html)
