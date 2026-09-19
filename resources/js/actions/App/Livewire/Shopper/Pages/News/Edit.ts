import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
const Edit8b428376a950a0049f4073ae14c3715e = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit8b428376a950a0049f4073ae14c3715e.url(options),
    method: 'get',
})

Edit8b428376a950a0049f4073ae14c3715e.definition = {
    methods: ["get","head"],
    url: '/cpanel/news/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
Edit8b428376a950a0049f4073ae14c3715e.url = (options?: RouteQueryOptions) => {
    return Edit8b428376a950a0049f4073ae14c3715e.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
Edit8b428376a950a0049f4073ae14c3715e.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Edit8b428376a950a0049f4073ae14c3715e.url(options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
Edit8b428376a950a0049f4073ae14c3715e.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Edit8b428376a950a0049f4073ae14c3715e.url(options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
    const Edit8b428376a950a0049f4073ae14c3715eForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: Edit8b428376a950a0049f4073ae14c3715e.url(options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
        Edit8b428376a950a0049f4073ae14c3715eForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Edit8b428376a950a0049f4073ae14c3715e.url(options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
        Edit8b428376a950a0049f4073ae14c3715eForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Edit8b428376a950a0049f4073ae14c3715e.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    Edit8b428376a950a0049f4073ae14c3715e.form = Edit8b428376a950a0049f4073ae14c3715eForm
    /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
const Editc29df0653a44ce576478a1d519db9264 = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Editc29df0653a44ce576478a1d519db9264.url(args, options),
    method: 'get',
})

Editc29df0653a44ce576478a1d519db9264.definition = {
    methods: ["get","head"],
    url: '/cpanel/news/{article}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
Editc29df0653a44ce576478a1d519db9264.url = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { article: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    article: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        article: args.article,
                }

    return Editc29df0653a44ce576478a1d519db9264.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
Editc29df0653a44ce576478a1d519db9264.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Editc29df0653a44ce576478a1d519db9264.url(args, options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
Editc29df0653a44ce576478a1d519db9264.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Editc29df0653a44ce576478a1d519db9264.url(args, options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
    const Editc29df0653a44ce576478a1d519db9264Form = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: Editc29df0653a44ce576478a1d519db9264.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
        Editc29df0653a44ce576478a1d519db9264Form.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Editc29df0653a44ce576478a1d519db9264.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
        Editc29df0653a44ce576478a1d519db9264Form.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: Editc29df0653a44ce576478a1d519db9264.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    Editc29df0653a44ce576478a1d519db9264.form = Editc29df0653a44ce576478a1d519db9264Form

/**
* Multiple routes resolve to \App\Livewire\Shopper\Pages\News\Edit::Edit, so this export is a
* dictionary keyed by URI rather than a callable. Call a specific route with `Edit['<uri>'](...)`,
* or import the route by name from your generated `routes/` directory.
*/
const Edit = {
    '/cpanel/news/create': Edit8b428376a950a0049f4073ae14c3715e,
    '/cpanel/news/{article}/edit': Editc29df0653a44ce576478a1d519db9264,
}

export default Edit