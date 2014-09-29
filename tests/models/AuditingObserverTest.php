<?php

namespace BishopB\ForumTest;

use Mockery as m;

class AuditingObserverTest extends \PHPUnit_Framework_TestCase
{
    public static function setupBeforeClass()
    {
        eval(sprintf(
            'namespace BishopB\Forum; function date() { return %s; }',
            var_export('2013-05-13 21:56:00', true)
        ));
        eval(sprintf(
            'namespace BishopB\ForumTest; function date() { return %s; }',
            var_export('2013-05-13 21:56:00', true)
        ));
    }

    public function setup()
    {
        $this->mocks['auth'] = m::mock('\Illuminate\Auth\AuthManager');
        $this->mocks['auth']->shouldReceive('user->getKey')->andReturn(242);

        $this->mocks['request'] = m::mock('\Illuminate\Http\Request');
        $this->mocks['request']->shouldReceive('getClientIp')->andReturn('10.1.242.7');
    }


    public function tearDown()
    {
        m::close();
    }

    /**
     * @dataProvider provides_model_data
     */
    public function test_model_create_adds_required_auditing_fields(array $data)
    {
        $model = $this->get_mock_model($data);

        // run system under test
        $auth = $this->mocks['auth'];
        $req  = $this->mocks['request'];
        $observer = new \BishopB\Forum\AuditingObserver($auth, $req);
        $observer->creating($model);

        // check observer updated the model as expected
        $checks = [
            [ 'InsertUserID', 'UpdateUserID', $auth->user()->getKey() ],
            [ 'DateInserted', 'DateUpdated', date() ],
            [ 'InsertIPAddress', 'UpdateIPAddress', $req->getClientIp() ],
        ];
        foreach ($checks as $check) {
            list ($i, $u, $v) = $check;
            if (empty($data[$i])) { // insert not already given
                $this->assertEquals($model->{$i}, $v); // insert set
                if (array_key_exists($u, $data)) { // corresponding update exists
                    $this->assertEquals($model->{$u}, $v); // update equals insert
                }
            } else { // insert given
                $this->assertEquals($model->{$i}, $data[$i]); // unchanged
                if (array_key_exists($u, $data)) { // corresponding update exists
                    $this->assertEquals($model->{$u}, $data[$u]); // unchanged also
                }
            }
        }
        foreach (['DeleteUserID', 'DateDeleted'] as $d) { // delete not touched
            if (array_key_exists($d, $data)) {
                $this->assertEquals($model->{$d}, $data[$d]);
            }
        }
    }

    /**
     * @dataProvider provides_model_data
     */
    public function test_model_update_adds_required_auditing_fields($data)
    {
        $model = $this->get_mock_model($data);

        // run system under test
        $auth = $this->mocks['auth'];
        $req  = $this->mocks['request'];
        $observer = new \BishopB\Forum\AuditingObserver($auth, $req);
        $observer->updating($model);

        // check expectations
        $checks = [
            [ 'InsertUserID', 'UpdateUserID', $auth->user()->getKey() ],
            [ 'DateInserted', 'DateUpdated', date() ],
            [ 'InsertIPAddress', 'UpdateIPAddress', $req->getClientIp() ],
        ];
        foreach ($checks as $check) {
            list ($i, $u, $v) = $check;
            if (! array_key_exists($u, $data)) {
                continue;
            }
            if (empty($data[$u])) { // update not given
                $this->assertEquals($model->{$u}, $v); // update set
                if (array_key_exists($i, $data)) { // corresponding insert exists
                    $this->assertEquals($model->{$i}, $data[$i]); // unchanged
                }
            } else { // update given
                $this->assertEquals($model->{$u}, $data[$u]); // unchanged
                if (array_key_exists($i, $data)) { // corresponding insert
                    $this->assertEquals($model->{$i}, $data[$i]); // unchanged also
                }
            }
        }
        foreach (['DeleteUserID', 'DateDeleted'] as $d) { // delete not touched
            if (array_key_exists($d, $data)) {
                $this->assertEquals($model->{$d}, $data[$d]);
            }
        }
    }

    /**
     * @dataProvider provides_model_data
     */
    public function test_model_delete_adds_required_auditing_fields($data)
    {
        $model = $this->get_mock_model($data);

        // run system under test
        $auth = $this->mocks['auth'];
        $req  = $this->mocks['request'];
        $observer = new \BishopB\Forum\AuditingObserver($auth, $req);
        $observer->deleting($model);

        // check expectations
        $checks = [
            'DeleteUserID' => $auth->user()->getKey(),
            'DateDeleted' => date(),
        ];
        foreach ($checks as $d => $v) {
            if (array_key_exists($d, $data)) {
                $this->assertEquals($model->{$d}, $v);
            }
        }
        $untouched = [
            'InsertUserID', 'DateInserted', 'InsertIPAddress',
            'UpdateUserID', 'DateUpdated', 'UpdateIPAddress',
        ];
        foreach ($untouched as $u) {
            if (array_key_exists($u, $data)) {
                $this->assertEquals($model->{$u}, $data[$u]);
            }
        }
    }

    public function provides_model_data()
    {
        return [
            [[
                'InsertUserID' => null, 'DateInserted' => null, 'InsertIPAddress' => null,
                'UpdateUserID' => null, 'DateUpdated' => null, 'UpdateIPAddress' => null,
                'DeleteUserID' => null, 'DateDeleted' => null,
            ]],
            [[
                'InsertUserID' => null, 'DateInserted' => null, 'InsertIPAddress' => null,
                'UpdateUserID' => null, 'DateUpdated' => null, 'UpdateIPAddress' => null,
            ]],
            [[
                'InsertUserID' => 2, 'DateInserted' => null, 'InsertIPAddress' => null,
                'UpdateUserID' => 2, 'DateUpdated' => null, 'UpdateIPAddress' => null,
            ]],
            [[
                'InsertUserID' => null, 'DateInserted' => null, 'InsertIPAddress' => null,
            ]],
            [[
                'InsertUserID' => 2, 'DateInserted' => null, 'InsertIPAddress' => null,
            ]],
        ];
    }

    public function get_mock_model(array $data)
    {
        $model = m::mock('\Illuminate\Database\Eloquent\Model[getAuditors]');
        foreach ($data as $k => $v) {
            $model->{$k} = $v;
        }
        $model->shouldReceive('getAuditors')->andReturn(array_keys($data));

        return $model;
    }
}
