<section class="mini-layout mod_stats">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang('Stats', 'mod_stats')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="" class="t-d_n m-r_15"><span class="f-s_14">←</span> <span class="t-d_u">{lang('Back', 'admin')}</span></a>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        {include_tpl('../left_block')}
        <div class="clearfix span9">
            {include_tpl('../time_and_filter_block_without_groupby_and_with_product_for_brandsInCategories')}
            {if $_GET['charType'] == false || $_GET['charType'] == 'pie'}
                <svg class="mypiechart pieChartStats" data-from="categories/getBrandsInCategoriesCharData" style="height: 800px;"></svg>
            {/if}
            {if $_GET['charType'] == 'bar'}
                <svg class="mypiechart barChartStats" data-from="categories/getBrandsInCategoriesCharData" style="height: 600px;"></svg>
            {/if}
        </div>
    </div>
    
</section>
