import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Shopper\ExportProductsXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportProductsXlsxController.php:15
 * @route '/cpanel/products/export.xlsx'
 */
const ExportProductsXlsxController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ExportProductsXlsxController.url(options),
    method: 'get',
})

ExportProductsXlsxController.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/export.xlsx',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Shopper\ExportProductsXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportProductsXlsxController.php:15
 * @route '/cpanel/products/export.xlsx'
 */
ExportProductsXlsxController.url = (options?: RouteQueryOptions) => {
    return ExportProductsXlsxController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Shopper\ExportProductsXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportProductsXlsxController.php:15
 * @route '/cpanel/products/export.xlsx'
 */
ExportProductsXlsxController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ExportProductsXlsxController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Shopper\ExportProductsXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportProductsXlsxController.php:15
 * @route '/cpanel/products/export.xlsx'
 */
ExportProductsXlsxController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ExportProductsXlsxController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Shopper\ExportProductsXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportProductsXlsxController.php:15
 * @route '/cpanel/products/export.xlsx'
 */
    const ExportProductsXlsxControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: ExportProductsXlsxController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Shopper\ExportProductsXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportProductsXlsxController.php:15
 * @route '/cpanel/products/export.xlsx'
 */
        ExportProductsXlsxControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ExportProductsXlsxController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Shopper\ExportProductsXlsxController::__invoke
 * @see app/Http/Controllers/Shopper/ExportProductsXlsxController.php:15
 * @route '/cpanel/products/export.xlsx'
 */
        ExportProductsXlsxControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ExportProductsXlsxController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    ExportProductsXlsxController.form = ExportProductsXlsxControllerForm
export default ExportProductsXlsxController