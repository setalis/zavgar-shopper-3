import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
const ExportAttributesXlsxController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ExportAttributesXlsxController.url(options),
    method: 'get',
})

ExportAttributesXlsxController.definition = {
    methods: ["get","head"],
    url: '/cpanel/attributes/export.xlsx',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
ExportAttributesXlsxController.url = (options?: RouteQueryOptions) => {
    return ExportAttributesXlsxController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
ExportAttributesXlsxController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ExportAttributesXlsxController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
ExportAttributesXlsxController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ExportAttributesXlsxController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
    const ExportAttributesXlsxControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: ExportAttributesXlsxController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
        ExportAttributesXlsxControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ExportAttributesXlsxController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shopper\ExportAttributesXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportAttributesXlsxController.php:15
 * @route '/cpanel/attributes/export.xlsx'
 */
        ExportAttributesXlsxControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ExportAttributesXlsxController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    ExportAttributesXlsxController.form = ExportAttributesXlsxControllerForm
export default ExportAttributesXlsxController