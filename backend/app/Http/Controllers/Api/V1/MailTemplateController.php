<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\MailTemplate;
use App\Services\MailTemplateService;
use App\Http\Requests\MailTemplates\CreateMailTemplateRequest;
use App\Http\Requests\MailTemplates\UpdateMailTemplateRequest;
use App\Http\Resources\MailTemplates\MailTemplateResource;

/**
 *  @OA\Tag(
 *      name="Mailtemplate",
 *      description="MailTemplate Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="mailTemplate",
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="subject",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="content",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="attachment",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="cc",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="bcc",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 */
class MailTemplateController extends Controller
{
    /**
     * @var  App\Services\MailTemplateService mailTemplateService
     */
    protected $mailTemplateService;

    public function __construct(MailTemplateService $mailTemplateService)
    {
        // Check permission
        // $this->middleware('permission:mailtemplate.show', ['only' => ['show']]);
        // $this->middleware('permission:mailtemplate.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:mailtemplate.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:mailtemplate.destroy', ['only' => ['destroy']]);

        $this->mailTemplateService = $mailTemplateService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/mail-template",
     *      tags={"MailTemplate"},
     *      operationId="indexMailTemplate",
     *      summary="List MailTemplate",
     *      @OA\Parameter(ref="#/components/parameters/page"),
     *      @OA\Parameter(ref="#/components/parameters/limit"),
     *      @OA\Parameter(ref="#/components/parameters/sort"),
     *      @OA\Parameter(ref="#/components/parameters/sortType"),
     *      @OA\Parameter(ref="#/components/parameters/condition"),
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/mailTemplate")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  ref="#/components/schemas/meta"
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  ref="#/components/schemas/links"
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $mailTemplate = $this->mailTemplateService->listMailTemplate($params);
        $result = MailTemplateResource::collection($mailTemplate);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MailTemplateRequest $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Post(
     *      path="/api/mail-template",
     *      tags={"MailTemplate"},
     *      operationId="storeMailTemplate",
     *      summary="Create MailTemplate",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/mailTemplate"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/mailTemplate",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateMailTemplateRequest $request, MailTemplate $mailTemplate)
    {
        try {
            $params = $request->all();
            $mailTemplate = $this->mailTemplateService->create($params);
            $result = new MailTemplateResource($mailTemplate);

            return response()->success(
                self::STORE,
                $result,
                self::MESSAGE_MAIL_TEMPLATE_UPDATE_SUCCESS,
                self::CODE_SUCCESS_201
            );
        } catch (\Exception $e) {
            return response()->failure(self::STORE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/mail-template/{id}",
     *      tags={"MailTemplate"},
     *      operationId="showMailTemplate",
     *      summary="Get MailTemplate",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/mailTemplate",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show(MailTemplate $mailTemplate)
    {
        $mailTemplate = $this->mailTemplateService->show($mailTemplate);
        $result = new MailTemplateResource($mailTemplate);

        return response()->success(self::STORE, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MailTemplateRequest $request
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/mail-template/{id}",
     *      tags={"MailTemplate"},
     *      operationId="updateMailTemplate",
     *      summary="Update MailTemplate",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/mailTemplate"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/mailTemplate",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(UpdateMailTemplateRequest $request, MailTemplate $mailTemplate)
    {
        try {
            $params = $request->all();
            $this->mailTemplateService->update($mailTemplate, $params);
            $result = new MailTemplateResource($mailTemplate);

            return response()->success(
                self::UPDATE,
                $result,
                self::MESSAGE_MAIL_TEMPLATE_UPDATE_SUCCESS,
                self::CODE_SUCCESS_201
            );
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/mail-template/{id}",
     *      tags={"MailTemplate"},
     *      operationId="deleteMailTemplate",
     *      summary="Delete MailTemplate",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Deleted",
     *      ),
     *  )
     */
    public function destroy(Request $request, MailTemplate $mailTemplate)
    {
        //$params = $request->all();
        $this->mailTemplateService->delete($mailTemplate);

        return response()->success(self::DELETE);
    }

    /**
     * Get mail template by type.
     *
     *  @OA\Get(
     *      path="/api/mail-template/get-mail-template-by-type",
     *      tags={"MailTemplate"},
     *      operationId="getMailTemplateByType",
     *      summary="List MailTemplate",
     *      @OA\Parameter(
     *          name="type",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/mailTemplate",
     *              ),
     *          ),
     *      ),
     *  )
     * @param mixed $request.
     * @return mixed
     */
    public function getMailTemplateByType(Request $request)
    {
        $params = $request->all();
        $mailtemplate = $this->mailTemplateService->getMailTemplateByType($params);
        $result = new MailTemplateResource($mailtemplate);

        return response()->success(self::SHOW, $result);
    }
}
