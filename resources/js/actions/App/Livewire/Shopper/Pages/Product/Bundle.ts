import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Livewire\Shopper\Pages\Product\Bundle::__invoke
 * @see app/Livewire/Shopper/Pages/Product/Bundle.php:7
 * @route '/cpanel/products/{product}/edit/bundle'
 */
const Bundle = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Bundle.url(args, options),
    method: 'get',
})

Bundle.definition = {
    methods: ["get","head"],
    url: '/cpanel/products/{product}/edit/bundle',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\Product\Bundle::__invoke
 * @see app/Livewire/Shopper/Pages/Product/Bundle.php:7
 * @route '/cpanel/products/{product}/edit/bundle'
 */
Bundle.url = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { product: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    product: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        product: args.product,
                }

    return Bundle.definition.url
            .replace('{product}', parsedArgs.product.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\Product\Bundle::__invoke
 * @see app/Livewire/Shopper/Pages/Product/Bundle.php:7
 * @route '/cpanel/products/{product}/edit/bundle'
 */
Bundle.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Bundle.url(args, options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\Product\Bundle::__invoke
 * @see app/Livewire/Shopper/Pages/Product/Bundle.php:7
 * @route '/cpanel/products/{product}/edit/bundle'
 */
Bundle.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Bundle.url(args, options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\Product\Bundle::__invoke
 * @see app/Livewire/Shopper/Pages/Product/Bundle.php:7
 * @route '/cpanel/products/{product}/edit/bundle'
 */
    const BundleForm = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: Bundle.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\Product\Bundle::__invoke
 * @see app/Livewire/Shopper/Pages/Product/Bundle.php:7
 * @route '/cpanel/products/{product}/edit/bundle'
 */
        BundleForm.get = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Bundle.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\Product\Bundle::__invoke
 * @see app/Livewire/Shopper/Pages/Product/Bundle.php:7
 * @route '/cpanel/products/{product}/edit/bundle'
 */
        BundleForm.head = (args: { product: string | number } | [product: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Bundle.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    Bundle.form = BundleForm
export default Bundle