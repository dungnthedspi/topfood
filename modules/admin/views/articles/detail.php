<div class="col-md-8 col-md-offset-1" id="comment-list-wrap">
			<?php if (count($articles)): ?>
				<?php foreach ($articles as $article): ?>
          <div class="comment-box">
            <div class="head-box">
							<?php echo image($article->avatar, array('class' => 'avatar-sm', 'width' => '50', 'height' => 50)) ?>
              <div class="author">
                <p><strong><?php echo $article->customer_name ?></strong></p>
                <small class="text-muted"><?php echo date("Y/m/d H:i", strtotime($article->date_created)) ?></small>
              </div>
              <span
                  class="product-vote"><?php echo number_format(($article->vote_price + $article->vote_service + $article->vote_quality + $article->vote_space + $article->vote_location) / 5, 1) ?></span>
            </div>
            <div class="content-box">
              <blockquote>
                <strong><?php echo $article->title ?></strong>
                <small><?php echo $article->description ?></small>
              </blockquote>
              <div class="image-box">
								<?php
                if($article->article_image!=''):
                 $images = explode(";", $article->article_image);
                  foreach ($images as $img): ?>
                    <div class="img-wrap">
                      <a href="<?php echo site_url($img)?>" target="_blank">
                      <img src="<?php echo site_url($img)?>" alt="" width="100%"/>
                      </a>
                    </div>
                <?php
                  endforeach;
                endif;
                ?>
              </div>
            </div>
          </div>
				<?php endforeach; ?>
			<?php endif; ?>
    </div>