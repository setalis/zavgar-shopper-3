import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
const DownloadProductImportXlsxTemplateController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DownloadProductImportXlsxTemplateController.url(options),
    method: 'get',
})

DownloadProductImportXlsxTemplateController.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/import-template.xlsx',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
DownloadProductImportXlsxTemplateController.url = (options?: RouteQueryOptions) => {
    return DownloadProductImportXlsxTemplateController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
DownloadProductImportXlsxTemplateController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DownloadProductImportXlsxTemplateController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
DownloadProductImportXlsxTemplateController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DownloadProductImportXlsxTemplateController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
    const DownloadProductImportXlsxTemplateControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: DownloadProductImportXlsxTemplateController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
        DownloadProductImportXlsxTemplateControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: DownloadProductImportXlsxTemplateController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shopper\DownloadProductImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadProductImportXlsxTemplateController.php:15
 * @route '/cpanel/products/import-template.xlsx'
 */
        DownloadProductImportXlsxTemplateControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: DownloadProductImportXlsxTemplateController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    DownloadProductImportXlsxTemplateController.form = DownloadProductImportXlsxTemplateControllerForm
export default DownloadProductImportXlsxTemplateController