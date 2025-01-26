import {getUniqueParams} from "./urlHelper.js";


document.addEventListener('DOMContentLoaded', function(){
    const paginationItems = document.querySelectorAll('.pagination li')
    paginationItems.forEach((item) => {
        item.addEventListener('click', (e) => {
            window.location.replace(generatePaginationUrl(e.currentTarget.getAttribute('value')))
        })
    });
})

export function pushPaginationParams(page, perPage)
{
    const urlParams = getUniqueParams()

    const tmpPage = getValidPageNumber(page || urlParams.get('page'));
    const tmpPerPage = getValidPerPage(perPage || urlParams.get('per_page'))

    urlParams.delete('page')
    urlParams.delete('per_page')

    urlParams.append('page', getValidPageNumber(tmpPage))
    urlParams.append('per_page', getValidPerPage(tmpPerPage))

    return urlParams;
}

export function stringifyPaginationParams(page, perPage)
{
    return pushPaginationParams(page, perPage).toString()
}

function getValidPageNumber(page)
{
    page = Number.parseInt(page);

    if(! Number.isInteger(page) || page < 1)
    {
        page = 1;
    }

    return page;
}

function getValidPerPage(perPage)
{
    perPage = Number.parseInt(perPage)

    if(! Number.isInteger(perPage) || (perPage < 5 || perPage > 100))
    {
        perPage = 10;
    }

    return perPage;
}

export function generatePaginationUrl(page)
{
    return `${window.location.origin}${window.location.pathname}?${stringifyPaginationParams(page)}`
}