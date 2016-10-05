<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('@web/js/sales-list.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'список разделов справки';
$this->params['breadcrumbs'][] = $this->title;


$link[1] = '/office/faq/visible/';
$link[0] = '/office/faq/draft/';
$link['view'] = '/office/faq/view/';
$link['edit'] = '/office/faq/edit/';

$icon[1] = '<span class="glyphicon glyphicon glyphicon-eye-close" aria-hidden="true"></span>';
$icon[0] = '<span class="glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span>';
$icon['img'] = '<span class="glyphicon glyphicon glyphicon-picture" aria-hidden="true"></span>';
$icon['view'] = '<span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span>';
$icon['edit'] = '<span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span>';

$u_icon[1] = '<span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span>';
$u_icon[4] = '<span class="glyphicon glyphicon-baby-formula" aria-hidden="true"></span>';
$u_icon[6] = '<span class="glyphicon glyphicon-education" aria-hidden="true"></span>';
$u_icon[10] = '<span class="glyphicon glyphicon-knight" aria-hidden="true"></span>';
$u_icon[12] = '<span class="glyphicon glyphicon-bishop" aria-hidden="true"></span>';
$u_icon[16] = '<span class="glyphicon glyphicon-tower" aria-hidden="true"></span>';
$u_icon[21] = '<span class="glyphicon glyphicon-queen" aria-hidden="true"></span>';
$u_icon[36] = '<span class="glyphicon glyphicon-king" aria-hidden="true"></span>';
$u_icon[77] = '<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>';

$color[1] = 'text-danger';
$color[0] = 'text-success';

$u_color[1] = 'text-muted';
$u_color[4] = 'text-danger';
$u_color[6] = 'text-danger';
$u_color[10] = 'text-success';
$u_color[12] = 'text-primary';
$u_color[16] = 'text-warning';
$u_color[21] = 'text-warning';
$u_color[36] = 'text-info';
$u_color[77] = 'text-info';

$hint[1] = 'Справка отключена, включить показ';
$hint[0] = 'Справка отображаетеся, пометить как черновик';
$hint['view'] = 'Просмотреть справку';
$hint['edit'] = 'Редактировать справку';


?>

		<article class="office-faq-list" itemscope itemtype="http://schema.org/Article">

			<h1><?= Html::encode($this->title) ?></h1>

			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<td class="text-info"><strong>ID</strong></td>
							<td class="text-info"><strong>IMG</strong></td>
							<td class="text-info"><strong>Заголовок</strong></td>
							<td class="text-info"><strong>Ярлык</strong></td>
							<td class="text-info"><strong>Дата создания</strong></td>
							<td class="text-info"><strong>Роль</strong></td>
							<td class="text-info" colspan="3"><strong>Управление</strong></td>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach( $model as $key => $faq ) {
					?>
						<tr>

							<td class="text-warning"><?php echo $faq->id; ?></td>

							<td class="text-<?php echo $faq->img==''?'danger':'success'; ?>">
								<span data-toggle="tooltip" data-placement="top" title="<?php echo $faq->img==''?'Изображение отсутствует':'Изображение добавлено'; ?>">
									<span class="glyphicon glyphicon glyphicon-picture" aria-hidden="true"></span>
								</span>
							</td>

							<td class="text-info"><a href="<?php echo Url::to(['/office/faq/edit/', 'id' => $faq->id]); ?>" data-toggle="tooltip" data-placement="top" title="Изменить новость"><?php echo $faq->title; ?></a>
							</td>

							<td class="text-warning"><?php echo $faq->slug; ?></td>

							<td class="text-warning"><?php echo $faq->created_at; ?></td>

							<td>
								<span class="<?php echo $u_color[$tax[$faq->category]['prohibition']]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $tax[$faq->category]['name']; ?>"><?php echo $u_icon[$tax[$faq->category]['prohibition']]; ?></span>
							</td>

							<td>
								<span class="<?php echo $color[$faq->draft]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $hint[$faq->draft]; ?>">
									<a class="control-link <?php echo $color[$faq->draft]; ?>" href="<?php echo Url::to([$link[$faq->draft], 'id' => $faq->id]); ?>">
										<?php echo $icon[$faq->draft]; ?></a>
								</span>
							</td>

							<td class="text-info">
								<a class="control-link text-info" href="<?php echo Url::to([$link['view'], 'id' => $faq->id]); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $hint['view']; ?>"><?php echo $icon['view']; ?></a>
							</td>

							<td class="text-info">
								<a class="control-link text-info" href="<?php echo Url::to([$link['edit'], 'id' => $faq->id]); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $hint['edit']; ?>"><?php echo $icon['edit']; ?></a>
							</td>

						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</div>

		</article><!-- /.office-faq-list -->
