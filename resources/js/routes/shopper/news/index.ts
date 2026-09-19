import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Livewire\Shopper\Pages\News\Index::__invoke
 * @see app/Livewire/Shopper/Pages/News/Index.php:7
 * @route '/cpanel/news'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/cpanel/news',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\News\Index::__invoke
 * @see app/Livewire/Shopper/Pages/News/Index.php:7
 * @route '/cpanel/news'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\News\Index::__invoke
 * @see app/Livewire/Shopper/Pages/News/Index.php:7
 * @route '/cpanel/news'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\News\Index::__invoke
 * @see app/Livewire/Shopper/Pages/News/Index.php:7
 * @route '/cpanel/news'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\News\Index::__invoke
 * @see app/Livewire/Shopper/Pages/News/Index.php:7
 * @route '/cpanel/news'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\News\Index::__invoke
 * @see app/Livewire/Shopper/Pages/News/Index.php:7
 * @route '/cpanel/news'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\News\Index::__invoke
 * @see app/Livewire/Shopper/Pages/News/Index.php:7
 * @route '/cpanel/news'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/cpanel/news/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/create'
 */
        createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    create.form = createForm
/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
export const edit = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/cpanel/news/{article}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
edit.url = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{article}', parsedArgs.article.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
edit.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
edit.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
    const editForm = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
        editForm.get = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Livewire\Shopper\Pages\News\Edit::__invoke
 * @see app/Livewire/Shopper/Pages/News/Edit.php:7
 * @route '/cpanel/news/{article}/edit'
 */
        editForm.head = (args: { article: string | number } | [article: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit.form = editForm
const news = {
    index: Object.assign(index, index),
create: Object.assign(create, create),
edit: Object.assign(edit, edit),
}

export default news