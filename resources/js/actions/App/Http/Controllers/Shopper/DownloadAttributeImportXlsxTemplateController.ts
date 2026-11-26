import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
const DownloadAttributeImportXlsxTemplateController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DownloadAttributeImportXlsxTemplateController.url(options),
    method: 'get',
})

DownloadAttributeImportXlsxTemplateController.definition = {
    methods: ["get","head"],
    url: '/cpanel/attributes/import-template.xlsx',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
DownloadAttributeImportXlsxTemplateController.url = (options?: RouteQueryOptions) => {
    return DownloadAttributeImportXlsxTemplateController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
DownloadAttributeImportXlsxTemplateController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DownloadAttributeImportXlsxTemplateController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
DownloadAttributeImportXlsxTemplateController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DownloadAttributeImportXlsxTemplateController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
    const DownloadAttributeImportXlsxTemplateControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: DownloadAttributeImportXlsxTemplateController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
        DownloadAttributeImportXlsxTemplateControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: DownloadAttributeImportXlsxTemplateController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shopper\DownloadAttributeImportXlsxTemplateController::__invoke
 * @see app/Http/Controllers/Shopper/DownloadAttributeImportXlsxTemplateController.php:15
 * @route '/cpanel/attributes/import-template.xlsx'
 */
        DownloadAttributeImportXlsxTemplateControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: DownloadAttributeImportXlsxTemplateController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    DownloadAttributeImportXlsxTemplateController.form = DownloadAttributeImportXlsxTemplateControllerForm
export default DownloadAttributeImportXlsxTemplateController