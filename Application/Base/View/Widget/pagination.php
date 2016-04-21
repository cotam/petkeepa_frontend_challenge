                                    <div class="pagination-holder">
                                        <ul class="pagination">
                                            <?php 
                                                  if ( $paged['paged'] > ( 1 + 3 ) ) {
                                                      $page_start = $paged['paged'] - 1;
                                                  } else {
                                                      $page_start = 1;
                                                  }

                                                  if ( $paged['paged'] < ( $paged['max_paged'] - 3 ) ) {
                                                      $page_end = $paged['paged'] + 1;
                                                  } else {
                                                      $page_end = $paged['max_paged'];
                                                  }
                                            ?>
                                            <?php if ( $paged['paged'] != 1 ) : ?>
                                                <li><a href="<?php echo $paged['url'] . '?paged=' . ( $paged['paged'] - 1 ); ?>">«</a></li>
                                            <?php endif; ?>
                                            <?php if ( $paged['paged'] > ( 1 + 3 ) ) : ?>
                                            <?php $start = ''; ?>
                                                <li><a href="<?php echo $paged['url'] . '?paged=1'; ?>">1</a></li>
                                                <li><a href="javascript:;" class="more" >...</a></li>
                                            <?php endif; ?>
                                            <?php while( ( $page_start++ ) <= $page_end ) : ?>
                                                <li><a href="<?php echo $paged['url'] . '?paged=' . ( $page_start - 1 ); ?>" <?php if ( ( $page_start - 1 ) == $paged['paged'] ) : echo 'class="active"'; endif; ?>><?php echo ( $page_start - 1 ); ?></a></li>
                                            <?php endwhile; ?>
                                            <?php if ( $paged['paged'] < ( $paged['max_paged'] - 3 ) ) : ?>
                                                <li><a href="javascript:;" class="more" >...</a></li>
                                                <li><a href="<?php echo $paged['url'] . '?paged=' . ( $paged['max_paged'] ); ?>"><?php echo $paged['max_paged']; ?></a></li>
                                            <?php endif; ?>
                                            <?php if ( $paged['paged'] != $paged['max_paged'] ) : ?>
                                                <li><a href="<?php echo $paged['url'] . '?paged=' . ( $paged['paged'] + 1 ); ?>">»</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
