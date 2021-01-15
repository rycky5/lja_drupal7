<?php
/**
  *
  * ESBJ - Ensino Superior Bureau Juridico <br>
  * NTI - Nucleo de Tecnologia da Informacao<br>
  *
  * CORE - Classes que servem para tds os sites.<br>
  *
  *  @package    Esbj
  *  @author     WebNTI <webnti@mauricionassau.com.br>
  *  @copyright  Copyright 2006, ESBJ.
  *  @version    1.0
  *  @link       http://www.esbj.com.br/NTI
  *  @since      1.0
  **/
  /**
    * Classe responsavel pela paginacao de resultados.
    *
    * @package     Esbj
    * @subpackage  Models
  **/
    class Pagination
    {
    /**
      * Variavel responsavel por armazenar os dados que serao passados no link.
      *
      *  @var  varchar
    **/
      private $getVars;
   /**
      * Variavel responsavel por armazenar a quantidade itens por pagina.
      *
      *  @var  int
    **/
      private $recordByPage;
   /**
      * Variavel responsavel por armazenar a quantidade de paginas.
      *
      *  @var  int
    **/
      private $pagesFound;
   /**
      * Variavel responsavel por armazenar o total de itens encontrados.
      *
      *  @var  int
    **/
      private $totalRecords;
   /**
      * Variavel responsavel por armazenar a pagina atual.
      *
      *  @var  int
    **/
      private $currentPage;
   /**
      * Variavel responsavel por armazenar o primeiro indice da pagina atual.
      *
      *  @var  int
    **/
      private $begin;
   /**
      * Variavel responsavel por armazenar o ultimo registro da pagina atual.
      *
      *  @var  int
    **/
      private $endd;
    /**
      * Construtor da classe modPagination.
      *
      * @access   public
      * @param    int      $page          Pagina atual
      * @param    int      $recordByPage  Registros por pagina
      * @return   void;
    **/
      public function __construct($pPage,$pRecordByPage)
      {
         $this->_setCurrentPage($pPage);
         $this->_setRecordByPage($pRecordByPage);
         $this->_setBegin();
         $this->_setEnd();
         $this->msg_textpreviousPage  = "« Voltar p&aacute;gina";
         $this->msg_textnextPage      = "Avan&ccedil;ar p&aacute;gina »";
         $this->msg_textfirstPage     = "« Primeira p&aacute;gina";
         $this->msg_textlastPage      = "&uacute;ltima p&aacute;gina »";
         $this->msg_previousPage      = "« Anterior";
         $this->msg_nextPage          = "pr&oacute;xima »";
         $this->msg_firstPage         = "« Primeira";
         $this->msg_lastPage          = "&Uacute;ltima »";
         $this->msg_next10Results     = "Pr&oacute;ximas 10 p&aacute;ginas »";
         $this->msg_previous10Results = "« 10 P&aacute;ginas anteriores";
         $this->msg_page		      = "Ir para P&aacute;gina";
         $this->msg_of		          = "de";
         $this->msg_to		          = "a";
      }
    /**
      * Funcao responsavel por retornar a propriedade getVars.
      *
      * @access  public
      * @since   1.0
    **/
      public function getGetVars()
      {
         return $this->getVars;
      }
    /**
      * Funcao responsavel por alterar a propriedade getVars.
      *
      * @access  public
      * @param   varchar  $pGetsVars  Dados que serao passados no link.
      * @since   1.0
    **/
      public function setGetVars($pGetsVars)
      {
         $this->getsVars = $pGetsVars;
      }
    /**
      * Funcao responsavel por retornar a propriedade begin.
      *
      * @access  public
      * @since   1.0
    **/
      public function getBegin()
      {
         return $this->begin;
      }
    /**
      * Funcao responsavel por alterar a propriedade begin.
      *
      * @access  private
      * @since   1.0
    **/
      private function _setBegin()
      {
         $this->begin = ($this->currentPage-1) * $this->recordByPage;
      }
    /**
      * Funcao responsavel por retornar a propriedade recordByPage.
      *
      * @access  public
      * @since   1.0
    **/
      public function getRecordByPage()
      {
         return $this->recordByPage;
      }
    /**
      * Funcao responsavel por alterar a propriedade recordByPage.
      *
      * @access  private
      * @param   varchar  $pRecords  Quantidade de registros.
      * @since   1.0
    **/
      private function _setRecordByPage($pRecords)
      {
         $this->recordByPage = $pRecords;
      }
    /**
      * Funcao responsavel por retornar a propriedade totalRecords.
      *
      * @access  public
      * @since   1.0
    **/
      public function getTotalRecords()
      {
         return $this->totalRecords;
      }
    /**
      * Funcao responsavel por alterar a propriedade totalRecords e Pagesfound.
      *
      * @access  public
      * @param   varchar  $pTotalRecords  Quantidade de registros.
      * @since   1.0
    **/
      public function setTotalRecords($pTotalRecords)
      {
         $this->totalRecords = $pTotalRecords;
         $this->pagesFound   = ceil($this->totalRecords / $this->recordByPage);
      }
    /**
      * Funcao responsavel por alterar a propriedade endd.
      *
      * @access  private
      * @since   1.0
    **/
      private function _setEnd()
      {
         $this->endd = ($this->totalRecords >= ($this->currentPage*$this->recordByPage)) ? ($this->currentPage * $this->recordByPage)-1 : $this->totalRecords-1;
      }
    /**
      * Funcao responsavel por alterar a propriedade currentPage.
      *
      * @access  private
      * @param   varchar  $pPage  Pagina.
      * @since   1.0
    **/
      private function _setCurrentPage($pPage)
      {
         $this->currentPage = (empty($pPage)) ? 1 : $pPage;
      }
    /**
      * Funcao responsavel por retornar a propriedade pagesFound.
      *
      * @access  public
      * @since   1.0
    **/
      public function getPagesFound()
      {
         return $this->pagesFound;
      }
    /**
      * Funcao responsavel por gerar lista com links atuais.
      *
      * @access  public
      * @since   1.0
    **/
      public function getListCurrentRecords()
      {
         $regFinal   = $this->recordByPage * $this->currentPage;
         $regInicial = $regFinal - $this->recordByPage;
         if ($regInicial == 0)
           $regInicial++;

         if ($this->currentPage == $this->pagesFound)
           $regFinal = $this->totalRecords;

         if ($this->currentPage > 1)
           $regInicial++;

         $result = "<div class='listando'>Listando registros $this->msg_of <b>$regInicial $this->msg_to $regFinal</b></div>";
         return $result;
      }
    /**
     * Funcao que gera a lista de paginas.
     */
      public function getFULLNavCP()
      {
         $result              = "";
         $previous            = $this->currentPage - 1;
         $next                = $this->currentPage + 1;
         $totalRecordsControl = $this->totalRecords;
         if (($totalRecordsControl%$this->recordByPage!=0))
           while($totalRecordsControl%$this->recordByPage!=0)
             $totalRecordsControl++; // $totalRecordsControl = 125

         $ultimo = substr($this->currentPage,-1);
         if ($ultimo == 0 && $this->currentPage <= 5) {
           $begin       = ($this->currentPage-9);
           $pageInicial = $this->currentPage;
           $end         = $this->currentPage;
         } else {
           $pageInicial = ($this->currentPage - $ultimo);
           $begin       = ($this->currentPage-$ultimo)+1;
           $end         = $pageInicial+10;
         }

         $num = $this->pagesFound;
         if ($end > $num)
           $end = $num;

         if ($num > 1) {
           $result .= "<div class='paginacao2'>";
           if ($this->currentPage >  2 )
             $result .= "<a href='".$this->getsVars."&page=1' title='".$this->msg_textfirstPage."' class='paginacaonomes'>".$this->msg_firstPage."</a>";

           if ($this->currentPage >  1 )
             $result .= "&nbsp;<a href='".$this->getsVars."&page=".($previous)."' title='".$this->msg_textpreviousPage."' class='paginacaonomes'>".$this->msg_previousPage."</a>";

           if ($this->pagesFound  < 10 ) {
             for ($a = $begin; $a <= $end ; $a++)
               $result .= ($a != $this->currentPage) ? ($this->getsVars == "") ? "<a href='&page=".$a."' title='".$this->msg_page.": ".$a."' class='paginacaonumeros'>&nbsp;".$a."&nbsp;</a>" : "<a href='".$this->getsVars."&page=".$a."' title='".$this->msg_page.": $a' class='paginacaonumeros'>&nbsp;".$a."&nbsp;</a>" : "<a href='javascript:void(0);' class='paginacaoativa'>&nbsp;".$a."&nbsp;</a>";
           } else {
             if ($this->currentPage == 1 )
               for ($a = $begin; $a <= $end; $a++)
                 $result .= ($a != $this->currentPage) ? ($this->getsVars == "") ? "<a href='&page=".$a."' title='".$this->msg_page.": ".$a."' class='paginacaonumeros'>&nbsp;".$a."&nbsp;</a>" : "<a href='".$this->getsVars."&page=".$a."' title='".$this->msg_page.": ".$a."' class='paginacaonumeros'>&nbsp;".$a."&nbsp;</a>" : " <a href='javascript:void(0);' class='paginacaoativa'>&nbsp;".$a."&nbsp;</a>";
             elseif ($this->currentPage <= 5)
               for ($a = $begin; $a <= $end; $a++)
               	 $result .= ($a!=$this->currentPage) ? ($this->getsVars =="") ? "<a href='&page=$a' onMouseOver=\"window.status='".$this->msg_page.": $a';return true\" title='".$this->msg_page.": $a' onMouseOut=\"window.status='';return true\" class='paginacaonumeros'>&nbsp;$a&nbsp;</a>" : "<a href='".$this->getsVars."&page=$a' title='".$this->msg_page.": $a' class='paginacaonumeros'>&nbsp;$a&nbsp;</a>" : "<a href='javascript:void(0);' class='paginacaoativa'>&nbsp;$a&nbsp;</a>";
             elseif ($this->currentPage == $end && $this->pagesFound > 10)
               for ($a = $end-9; $a <= $end; $a++)
               	 $result .= ($a!=$this->currentPage) ? ($this->getsVars =="") ? "<a href='&page=$a' onMouseOver=\"window.status='".$this->msg_page.": $a';return true\" title='".$this->msg_page.": $a' onMouseOut=\"window.status='';return true\" class='paginacaonumeros'>&nbsp;$a&nbsp;</a>" : "<a href='".$this->getsVars."&page=$a' title='".$this->msg_page.": $a' class='paginacaonumeros'>&nbsp;$a&nbsp;</a>" : "<a href='javascript:void(0);' class='paginacaoativa'>&nbsp;$a&nbsp;</a>";
             else {
               $final = (($this->currentPage + 5) <= $end) ? $this->currentPage + 5 : $end;
               for ($a = $this->currentPage-5; $a <= $final ; $a++)
               	 $result .= ($a!=$this->currentPage) ? ($this->getsVars =="") ? "<a href='&page=$a' onMouseOver=\"window.status='".$this->msg_page.": $a';return true\" title='".$this->msg_page.": $a' onMouseOut=\"window.status='';return true\" class='paginacaonumeros'>&nbsp;$a&nbsp;</a>" : "<a href='".$this->getsVars."&page=$a' title='".$this->msg_page.": $a' class='paginacaonumeros'>&nbsp;$a&nbsp;</a>" : "<a href='javascript:void(0);' class='paginacaoativa'>&nbsp;$a&nbsp;</a>";
             }
           }

           $next = ($next > $num) ? $num : $next;
           if (($this->currentPage < $this->pagesFound) && ($this->pagesFound >= 1))
             $result .= " <a href='".$this->getsVars."&page=".($next)."'  title='".$this->msg_textnextPage."' class='paginacaonomes'>".$this->msg_nextPage."</a>";

           if (($this->pagesFound>2)&&($this->currentPage < $this->pagesFound-1))
             $result .=  "&nbsp;<a href='".$this->getsVars."&page=".$num."'  title='".$this->msg_textlastPage."' class='paginacaonomes'>".$this->msg_lastPage."</a>";
           $result .= "</div>";
         }

         return $result;
      }
    }
?>