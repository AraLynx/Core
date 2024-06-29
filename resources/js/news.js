/*FIND + REPLACE page -> actual_news*/
//alert("JS LOADED");
const linkAjax = "/"+ROOT+"ajax/news/";

$(document).ready(function(){
});

function newsShowSubContent(subContent){
    $(".page_content").addClass("d-none");
    $("#news_"+subContent).removeClass("d-none");
    if(subContent == "settings")
    {
       settingsGetNewsCategories();
    }
    else if(subContent == "news")
    {
    }
}

//SETTINGS : NEWS CATEGORY
    function settingsGetNewsCategoriesSuccess(result){
        TDE.settingsKendoGridNewsCategories.populate(result.datas);
    }
    function settingsAddNewsCategorySuccess(result){
        if(!result.data.IsError){
            TDE.settingsKendoWindowAddNewsCategory.close();
            settingsGetNewsCategories();
        }
        else{
            console.table(result.data);
            TDE.commonModal.Display({
                body : result.data.ErrorMessage
            });
        }
    }
    function settingsEditNewsCategoryPrepareData(Id, Name, IsEnable){
        $("#settingsEditNewsCategoryId").val(Id);
        TDE.settingsEditNewsCategoryName.value(Name);
        if(IsEnable)TDE.settingsEditNewsCategoryIsEnable.check(true);
        else TDE.settingsEditNewsCategoryIsEnable.check(false);
        TDE.settingsKendoWindowEditNewsCategory.center().open();
    }
    function settingsEditNewsCategorySuccess(result){
        if(!result.data.IsError){
            TDE.settingsKendoWindowEditNewsCategory.close();
            settingsGetNewsCategories();
        }
        else{
            console.table(result.data);
            TDE.commonModal.Display({
                body : result.data.ErrorMessage
            });
        }
    }
//NEWS CATEGORY

//NEWS : GET NEWSES
    function newsGetGetNewsesSuccess(result){
        TDE.newsKendoGridNewses.populate(result.datas);
    }
//NEWS : GET NEWSES


//NEWS : ADD NEWS



    //NEWS : ADD NEWS ADD SECTION
        function newsAddNewsAddNewsSectionSuccess(){

        }

    //NEWS : ADD NEWS ADD SECTION
//NEWS : ADD NEWS
