<?php use Illuminate\Pagination\Paginator; ?>
<div class="row" style="margin: 0;">
	<div class="col-md-12">
		<ul class="pagination">
			@if ($paginator->lastPage() > 1)
				@if (!$paginator->onFirstPage())
					<li><a class="des-font border" href="{{ PaginateRoute::previousPageUrl($paginator) }}"><i class="ti-arrow-left"></i></a></li>
				@endif
				@for ($i = 1; $i <= $paginator->lastPage(); $i++)
					<?php
					$half_total_links = floor(6 / 2);
					$from = $paginator->currentPage() - $half_total_links;
					$to = $paginator->currentPage() + $half_total_links;
					if ($paginator->currentPage() < $half_total_links) {
						$to += $half_total_links - $paginator->currentPage();
					}
					if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
						$from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
					}
					?>
					@if ($from < $i && $i < $to)
						@if($paginator->currentPage() == $i)
							<li><a href="#" class="des-font active">{{$i}}</a></li>
						@else
							<li><a href="{{ PaginateRoute::pageUrl($i) }}" class="des-font">{{$i}}</a></li>
						@endif
					@endif
				@endfor
				@if($paginator->hasMorePages())
					<li><a class="des-font border" href="{{ PaginateRoute::nextPageUrl($paginator) }}"><i class="ti-arrow-right"></i></a></li>
				@endif
			@endif
		</ul>
	</div>
</div>