<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use cebe\markdown\GithubMarkdown;

use App\Models\Content;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // make authentication mandatory?
        $this->middleware('auth');
    }

    /**
     * Save a page
     *
     * @param Request $request The request object
     * @return null
     */
    private function savePage(Request $request)
    {
        $page = [
            'title' => $request->input('title'),
            'content' => $request->input('body'),
            'path' => $request->input('pagePath'),
        ];

        // update or new?
        if ($request->input('pageId', false)) {
            // update page
            Content::find($request->input('pageId'))
                ->update($page);

            // redirect
            return redirect()->route('listcontent');
        }

        Content::create($page);
        return redirect()->route('listcontent');
    }

    /**
     * Create/edit a content page
     *
     * @param Request $request The request object
     * @param int     $pageId  An optional page ID for editing
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $pageId = 0)
    {
        if (Gate::denies('can-manage-properties')) {
            abort(403, 'Unauthorized action');
        }

        $params = [
            'pageId' => null,
            'title' => '',
            'body' => '',
            'pagePath' => '',
        ];

        // have we been passed a page id to load?
        if ($pageId !== 0) {
            $page = Content::find($pageId);
            $params = [
                'pageId' => $pageId,
                'title' => $page->title,
                'body' => $page->content,
                'pagePath' => $page->path,
            ];
        }

        // inject the form parameters
        $params = [
            'pageId' => $request->input('pageId', $params['pageId']),
            'title' => $request->input('title', $params['title']),
            'body' => $request->input('body', $params['body']),
            'pagePath' => $request->input('pagePath', $params['pagePath']),
        ];

        // are we saving a page?
        if ($request->input('save', false)) {
            return $this->savePage($request);
        }

        // until we decide on a dashboard layout, go straight to properties
        return view('content.edit', $params);
    }

    /**
     * List available pages
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return view('content.list', ['pages' => Content::all()]);
    }

    /**
     * Render a page
     *
     * @return \Illuminate\Http\Response
     */
    public function render(string $page)
    {
        $page = Content::where('path', $page)->first();

        $renderer = new GithubMarkdown();

        return view('content.view', [
            'title' => $page->title,
            'rendered' => $renderer->parse($page->content),
        ]);
    }
}
