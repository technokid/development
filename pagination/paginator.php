<?php
/**
 * User: Sergey
 * Date: 17.09.13
 * Pagination Class
 */

class Paginator{

	/* задать количество элементов на странице.*/
	private $_perPage;

	/* установить/получить параметр для выборки номер страницы */
	private $_instance;

	/* задает номер страницы. */
	private $_page;

	/* установить предел для источника данных */
	private $_limit;

	/* установить общее количество записей. */
	private $_totalRows = 0;

	/* конструктор */
	public function __construct($perPage,$instance){
		$this->_instance = $instance;
		$this->_perPage = $perPage;
		$this->set_instance();
	}

	/*создает отправную точку для ограничения набора данных*/
	private function get_start(){
		return ($this->_page * $this->_perPage) - $this->_perPage;
	}

	/*задает экземпляр параметра, если числовое значение 0, то устанавливается в 1*/
	private function set_instance(){
		$this->_page = (int) (!isset($_GET[$this->_instance]) ? 1 : $_GET[$this->_instance]);
		$this->_page = ($this->_page == 0 ? 1 : $this->_page);
	}

	/*собирать значение и присваивает его totalRows*/
	public function set_total($_totalRows){
		$this->_totalRows = $_totalRows;
	}

	/*возвращает предел для источника данных, назвав get_start метод и передав количество элементов на странице*/
	public function get_limit(){
		return "LIMIT ".$this->_perPage." offset ".$this->get_start();
	}

	/*создать HTML ссылки для навигации по набору данных*/
	public function page_links($path='&',$ext=null, $onclick=null)
	{
		$adjacents = "2";
		$prev = $this->_page - 1;
		$next = $this->_page + 1;
		$lastpage = ceil($this->_totalRows/$this->_perPage);
		$lpm1 = $lastpage - 1;

		if($onclick != null){
			$onclick = ' onclick="showpage($(this));return false;"';
		}

		$pagination = "";
		if($lastpage > 1)
		{
			$pagination .= "<div class='pagination'>";
			if ($this->_page > 1)
				$pagination.= "<a href='".$path."$this->_instance=$prev"."$ext' ".$onclick.">« Предидущая</a>";
			else
				$pagination.= "<span class='disabled'>« previous</span>";

			if ($lastpage < 7 + ($adjacents * 2))
			{
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $this->_page)
						$pagination.= "<span class='current'>$counter</span>";
					else
						$pagination.= "<a href='".$path."$this->_instance=$counter"."$ext' ".$onclick.">$counter</a>";
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))
			{
				if($this->_page < 1 + ($adjacents * 2))
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $this->_page)
							$pagination.= "<span class='current'>$counter</span>";
						else
							$pagination.= "<a href='".$path."$this->_instance=$counter"."$ext' ".$onclick.">$counter</a>";
					}
					$pagination.= "...";
					$pagination.= "<a href='".$path."$this->_instance=$lpm1"."$ext' ".$onclick.">$lpm1</a>";
					$pagination.= "<a href='".$path."$this->_instance=$lastpage"."$ext' ".$onclick.">$lastpage</a>";
				}
				elseif($lastpage - ($adjacents * 2) > $this->_page && $this->_page > ($adjacents * 2))
				{
					$pagination.= "<a href='".$path."$this->_instance=1"."$ext' ".$onclick.">1</a>";
					$pagination.= "<a href='".$path."$this->_instance=2"."$ext' ".$onclick.">2</a>";
					$pagination.= "...";
					for ($counter = $this->_page - $adjacents; $counter <= $this->_page + $adjacents; $counter++)
					{
						if ($counter == $this->_page)
							$pagination.= "<span class='current'>$counter</span>";
						else
							$pagination.= "<a href='".$path."$this->_instance=$counter"."$ext' ".$onclick.">$counter</a>";
					}
					$pagination.= "...";
					$pagination.= "<a href='".$path."$this->_instance=$lpm1"."$ext' ".$onclick.">$lpm1</a>";
					$pagination.= "<a href='".$path."$this->_instance=$lastpage"."$ext' ".$onclick.">$lastpage</a>";
				}
				else
				{
					$pagination.= "<a href='".$path."$this->_instance=1"."$ext' ".$onclick.">1</a>";
					$pagination.= "<a href='".$path."$this->_instance=2"."$ext' ".$onclick.">2</a>";
					$pagination.= "..";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $this->_page)
							$pagination.= "<span class='current'>$counter</span>";
						else
							$pagination.= "<a href='".$path."$this->_instance=$counter"."$ext' ".$onclick.">$counter</a>";
					}
				}
			}

			if ($this->_page < $counter - 1)
				$pagination.= "<a href='".$path."$this->_instance=$next"."$ext' ".$onclick.">Следующая »</a>";
			else
				$pagination.= "<span class='disabled'>next »</span>";
			$pagination.= "</div>\n";
		}
		return $pagination;
	}
}
