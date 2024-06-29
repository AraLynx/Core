
$(document).ready(function(){
    TDE.defaultSwitchBranchBranchId.populate(otherBranches);
    if(otherBranches.length == 1){
        TDE.defaultSwitchBranchBranchId.select(0);
    }
});

function defaultSwitchBranchSuccess(){
    TDE.defaultKendoWindowSwitchBranch.close();
    location.reload();
}
