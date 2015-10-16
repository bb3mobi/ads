<?php
/**
*
* @package phpBB3 Advertisement Management
* @version $Id: ads.php 108 2010-05-31 04:02:56Z exreaction@gmail.com $
* @copyright (c) 2008 EXreaction, Lithium Studios
* @port in phpBB3.1 BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ADVERTISEMENT_MANAGEMENT_CREDITS'		=> '<a href="http://bb3.mobi/forum/viewtopic.php?t=185" title="Meus Anúncios" rel="nofollow">Anúncios por</a> <a href="http://www.lithiumstudios.org/" rel="nofollow">Gerenciador de Anúncios</a>',
	'MY_ADS'								=> 'Meus Anúncios',

	// Default Positions
	'ABOVE_FOOTER'			=> 'Acima do rodapé',
	'ABOVE_HEADER'			=> 'Acima do cabeçalho',
	'ABOVE_POSTS'			=> 'Acima das postagens',
	'AFTER_EVERY_POST'		=> 'Após cada postagem, exceto a primeira',
	'AFTER_FIRST_POST'		=> 'Após a primeira postagem',
	'BELOW_FOOTER'			=> 'Abaixo do rodapé',
	'BELOW_HEADER'			=> 'Abaixo do cabeçalho',
	'BELOW_POSTS'			=> 'Abaixo das postagens',
	'SIDEBAR_LEFT'			=> 'Lateral esquerda',
	'SIDEBAR_RIGHT'			=> 'Lateral direita',
	'EXTERNAL_BLOCK'		=> 'Bloco externo',

	// ACP
	'0_OR_NA'									=> '0 ou N/A',

	'ACP_ADVERTISEMENT_MANAGEMENT_EXPLAIN'		=> 'Aqui você pode alterar as configurações do Gerenciador de Anúncios, Adicionar/Remover/Editar posições de anúncios e and Adicionar/Remover/Editar anúncios.',
	'ACP_ADVERTISEMENT_MANAGEMENT_SETTINGS'		=> 'Configurações do Gerenciador de Anúncios',
	'ADS_ACCURATE_VIEWS'						=> 'Precisão do Contador de Visualizações',
	'ADS_ACCURATE_VIEWS_EXPLAIN'				=> 'Torna a contagem de visualizações dos anúncios muito mais precisa, mas aumenta a carga do servidor.',
	'ADS_COUNT_CLICKS'							=> 'Contador de Cliques em Anúncios',
	'ADS_COUNT_CLICKS_EXPLAIN'					=> 'Se definido para não, os cliques nos anúncios não serão contados (menor carga do servidor).',
	'ADS_COUNT_VIEWS'							=> 'Contador de Visualizações de Anúncios',
	'ADS_COUNT_VIEWS_EXPLAIN'					=> 'Se definido para não, as visualizações dos anúncios não serão contados (menor carga do servidor).',
	'AD_CREATED'								=> 'Anúncio Criado',
	'ADS_ENABLE'								=> 'Ativar Anúncios',
	'ADS_GROUP'									=> 'Grupo do Proprietário do Anúncio',
	'ADS_GROUP_EXPLAIN'							=> 'O Grupo do Proprietário do Anúncio será adicionado (não é necessário, apenas se você desejar adicioná-los a um grupo específico para controlá-los).',
	'ADS_RULES_FORUMS'							=> 'Usar Regras de Fórum para Anúncios',
	'ADS_RULES_FORUMS_EXPLAIN'					=> 'Se ativado, permite você controlar cada fórum onde o anúncio será exibido. Se você não planeja usar isso deve definir como Não para reduzir o consumo de recursos.',
	'ADS_RULES_GROUPS'							=> 'Usar Regras de Grupo para Anúncios',
	'ADS_RULES_GROUPS_EXPLAIN'					=> 'Se ativado, permite você controlar cada grupo específico que verá ou não os anúncios. Se você não planeja usar isso deve definir como Não para reduzir o consumo de recursos.',
	'ADS_VERSION'								=> 'Versão do Gerenciador de Anúncios',
	'ADVERTISEMENT'								=> 'Anúncios',
	'ADVERTISEMENT_MANAGEMENT_UPDATE_SUCCESS'	=> 'As configurações do Gerenciador de Anúncios foram atualizadas com sucesso!',
	'AD_ADD_SUCCESS'							=> 'Anúncio adicionado com sucesso!',
	'AD_CLICK_LIMIT'							=> 'Limite de Cliques do Anúncio',
	'AD_CLICK_LIMIT_EXPLAIN'					=> '0 para Desativar, caro contrário o anúncio será desativado automaticamente após este número de cliques informado.',
	'AD_CLICKS'									=> 'Cliques do Anúncio',
	'AD_CLICKS_EXPLAIN'							=> 'Atual número de cliques neste anúncio (se configurado corretamente).',
	'AD_CODE'									=> 'Código do Anúncio',
	'AD_CODE_EXPLAIN'							=> 'O Código do Anúncio que deseja é exibido aqui. Todo código deve ser colocado em forma de HTML puro, BBcodes não são suportados.<br /><strong>Se desejar ativar o contador de cliques, use {COUNT_CLICK} em qualquer lugar onde o atributo onclick seja permitido (uma tag por exemplo).</strong>',
	'AD_EDIT_SUCCESS'							=> 'Anúncio editado com Sucesso!',
	'AD_ENABLED'								=> 'Anúncio Ativado',
	'AD_ENABLED_EXPLAIN'						=> 'Desmarque esta opção para desativar a exibição deste anúncio.',
	'AD_FORUMS'									=> 'Lista de Fóruns',
	'AD_FORUMS_EXPLAIN'							=> 'Selecione os fóruns onde deseja que este anúncio seja exibido. Você pode selecionar vários fóruns segurando pressionada a tecla CTRL enquanto clica nos itens da lista.',
	'AD_GROUPS'									=> 'Grupos',
	'AD_GROUPS_EXPLAIN'							=> 'Selecione os grupos para os quais você deseja que <strong>NÃO</strong> sejam exibidos os anúncios. Você pode selecionar vários grupos segurando pressionada a tecla CTRL enquanto clica nos itens da lista.',
	'AD_LIST_NOTICE'							=> 'Cliques no Anúncio somente estarão disponíveis se você usou o {COUNT_CLICK} no lugar em que funciona o atributo onclick.',
	'AD_MAX_VIEWS'								=> 'Máximo de Visualizações',
	'AD_MAX_VIEWS_EXPLAIN'						=> 'Máximo de visualizações antes do anúncio deixar de ser exibido. <strong>0 para Sem Limite Máximo</strong>.',
	'AD_NAME'									=> 'Nome do Anúncio',
	'AD_NAME_EXPLAIN'							=> 'Isto somente é utilizado para você reconhecer o anúncio.',
	'AD_NOT_EXIST'								=> 'O anúncio selecionado não existe.',
	'AD_NOTE'									=> 'Anotações do Anúncio',
	'AD_NOTE_EXPLAIN'							=> 'Informe anotações sobre este anúncio se você desejar. Essas anotações não serão exibidas em outros lugares, exceto no ACP.',
	'AD_OWNER'									=> 'Proprietário do Anúncio',
	'AD_OWNER_EXPLAIN'							=> 'O usuário proprietário deste anúncio (pode ver isso em seu painel de anúncios).',
	'AD_POSITIONS'								=> 'Posições',
	'AD_POSITIONS_EXPLAIN'						=> 'Selecione as posições onde deseja que este anúncio seja exibido.',
	'AD_PRIORITY'								=> 'Prioridade do Anúncio',
	'AD_PRIORITY_EXPLAIN'						=> 'Quanto maior o número, mais provável que o anúncio seja exibido. Por exemplo, um anúncio com prioridade 2 será exibido com 2 vezes mais frequência do que um anúncio com prioridade 1, assim como um anúncio de prioridade 3 será exibido com 3 vezes mais frequência, etc.',
	'AD_TIME_END'								=> 'Executar até',
	'AD_TIME_END_BEFORE_NOW'					=> 'O prazo final que você informou é anterior ao tempo atual. Por favor, certifique-se de que está usando uma data compatível com a função strtotime do PHP.',
	'AD_TIME_END_EXPLAIN'						=> 'Informe uma data válida para o término de exibição do anúncio. Após chegar à data o anúncio será desativado automaticamente. Note que isto usa a função <a href="http://us2.php.net/manual/en/function.strtotime.php">strtotime</a> do PHP, logo, certifique-se de formatá-lo corretamente ou não será definido.<br /><br /><strong>Esta data final não é totalmente precisa com fusos horários e tal, então, horários exatos não deve ser invocado. É recomendável que você planeje uma precisão dentro de um dia do tempo determinado.</strong>',
	'AD_VIEW_LIMIT'								=> 'Limite de Visualizações do Anúncio',
	'AD_VIEW_LIMIT_EXPLAIN'						=> '0 para desativar, caso contrário o anúncio será desativado após atingir este número de visualizações.',
	'AD_VIEWS'									=> 'Visualizações do Anúncio',
	'AD_VIEWS_EXPLAIN'							=> 'Número atual de visualizações deste anúncio.',
	'ALL_FORUMS_EXPLAIN'						=> 'Selecione para exibir em todos os fóruns e páginas. Note que se desmarcar isso o anúncio não será exibido em páginas relacionadas que não sejam em fóruns (como na página de FAQ ou Dúvidas Frequêntes, por exemplo).',

	'CREATE_AD'									=> 'Criar Anúncio',
	'CREATE_POSITION'							=> 'Criar Posição',
	'COPY'										=> 'Copiar',

	'DELETE_AD'									=> 'Excluir Anúncio',
	'DELETE_AD_CONFIRM'							=> 'Você tem certeza que deseja remover este anúncio?',
	'DELETE_AD_SUCCESS'							=> 'O anúncio foi removido com sucesso!',
	'DELETE_POSITION'							=> 'Excluir Posição',
	'DELETE_POSITION_CONFIRM'					=> 'Você tem certeza que deseja excluir esta posição? Se você remover uma posição, qualquer anúncio configurado para exibição nela não será mais exibido.',
	'DELETE_POSITION_SUCCESS'					=> 'A posição foi excluída com sucesso!',

	'FALSE'										=> 'Falso',

	'NO_ADS_CREATED'							=> 'Nenhum Anúncio Criado',
	'NO_AD_NAME'								=> 'Você deve definir um nome para o anúncio.',
	'NO_POSITIONS_CREATED'						=> 'Nenhuma Posição Criada',

	'POSITION'									=> 'Posição',
	'POSITION_CODE'								=> 'Código da Posição',
	'POSITION_EDIT_SUCCESS'						=> 'Posição Editada com Sucesso!',
	'POSITION_NAME'								=> 'Nome da Posição',
	'POSITION_NAME_EXPLAIN'						=> 'O nome da posição.',
	'POSITION_NOT_EXIST'						=> 'A posição selecionada não existe.',
	'POSTITION_ADD_SUCCESS'						=> 'Posição Adicionada com Sucesso!',
	'POSTITION_ALREADY_EXIST'					=> 'Você já tem uma posição com este nome.',

	'TRUE'										=> 'Verdadeiro',
));
