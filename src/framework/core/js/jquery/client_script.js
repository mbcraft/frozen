
function call(controller_name,function_name,params)
{
    return $.get("/actions/"+controller_name+"/"+function_name+".json",params);
}

function include_block(block_name,params)
{
    return $.get("/resources/blocks/"+block_name,params);
}

function include_block_if(block_name_1,block_name_2,condition,params)
{
    if (condition)
        return include_block(block_name_1,params);
    else
        return include_block(block_name_2,params);

}