<section id="EventBanner" class="banner-default" style="background-image: url({{url:site}}{{theme:path}}/img/event-banner.jpg)">
    <div class="container">
        <div class="label text-light text-uppercase">EVENT</div>
        <h2 class="text-light">RAGAM KESERUAN<br /> SINGAPURA</h2>
    </div>
</section>
<section id="EventList" class="events">
    <div class="container">
        <div class="top-area text-center">
            EVENT ON : 
            <div class="dropdown-area">
                <a href="" class="dropdown dropdown-toggle dropdown-toggle-split text-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                        if ($this->session->userdata('year') == 'all') {
                            echo 'All Event';
                        } elseif($this->session->userdata('month') == 'year') {
                            echo 'Year'.' '.$this->session->userdata('year');
                        }else{
                            echo $monthlist[$this->session->userdata('month')-1].' '.$this->session->userdata('year');
                        }
                        
                    ?>  
                    </a>
                <div class="dropdown-menu">
                    <a href="<?php echo site_url('event/bymonth/year/all'); ?>" class="year <?php echo ($this->session->userdata('year') == 'all') ? 'active' : '' ; ?>">ALL Event</a>
                    <?php 
                        foreach ($datelist as $key => $value) {
                            if($this->session->userdata('month') == 'year' and $this->session->userdata('year') == $key){
                                echo '<a href="'.site_url('event/bymonth/year/'.$key).'" class="year active"> Year '.$key.'</a>';       
                            }else{
                                echo '<a href="'.site_url('event/bymonth/year/'.$key).'" class="year"> Year '.$key.'</a>';
                            }
                            foreach ($value as $k => $v) {
                                if($this->session->userdata('month') == $v['month'] and $this->session->userdata('year') == $v['year']){
                                    echo '<a href="#" class="month active">'.$monthlist[$v['month']-1].' '.$v['year'].'</a>';      
                                }else{
                                    echo '<a href="'.site_url('event/bymonth/'.$v['month'].'/'.$v['year']).'" class="month" >'.$monthlist[$v['month']-1].' '.$v['year'].'</a>';      
                                }
                            }
                        }
                    ?>
                </div>                
            </div>
        </div>
        <div class="list-event-tags">
            <a href="<?php echo site_url('event/tag/all'); ?>" class="<?php echo (!$this->session->userdata('tag')) ? 'active' : '' ; ?>">SEMUA KATEGORI</a>
            {{tags}}
                <a href="{{url}}" class="{{class}}">{{tag}}</a>
            {{/tags}}
        </div>
        <?php if ($result->num_rows() > 0): ?>
            <div class="list-events row">
                <?php foreach($result->result() as $res) { ?>
                    <div class="col-md-4">
                        <a href="<?php echo $res->link ?>" class="event buy-now <?php echo $res->class; ?>" target="_blank">
                            <div class="img lazy" data-src="<?php echo $res->url ?>"></div>
                            <div class="detail">
                                <div class="text-uppercase text-main-color date"><?php echo $res->date; ?></div>
                                <h4><?php echo $res->title; ?></h4>
                                <p><?php echo $res->description; ?></p>                            
                            </div>
                            <div class="bottom">
                                <div class="loc-n-time">
                                    <div class="row">
                                        <div class="col-4 time">
                                            <span>WAKTu</span>
                                            <div class="table-lo">
                                                <div class="cell"><?php echo $res->time; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-8 location">
                                            <span>LOKASI</span>
                                            <div class="table-lo">
                                                <div class="cell"><?php echo $res->location; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-area text-center">
                                    <button class="main-btn-no-hover">SELANJUTNYA</button>
                                </div>                                
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <?php echo $pagination; ?>            
        <?php else: ?>
            <div class="text-center font-weight-bold text-uppercase" style="height: 200px;">
                <?php if ($this->session->userdata('month') == 'year'){ ?>
                    TIDAK ADA EVENT UNTUK <?php echo $this->session->userdata('year'); ?>
                <?php }else{ ?>
                TIDAK ADA EVENT UNTUK <?php echo $monthlist[$this->session->userdata('month')-1].' '.$this->session->userdata('year'); ?>
                <?php } ?>
            </div>
        <?php endif ?>

    </div>
</section>