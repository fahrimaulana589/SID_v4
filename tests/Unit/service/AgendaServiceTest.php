<?php

namespace Tests\Unit\service;

use Tests\TestCase;
use App\Models\Agenda;
use App\Service\AgendaService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgendaServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_getAll()
    {

        Agenda::factory(4)->create();
        $service = new AgendaService;

        $agendas = $service->getAll();

        $this->assertEquals(4,count($agendas));

    }

    public function test_getBy()
    {

        Agenda::factory(8)->create();
        $service = new AgendaService;

        $agendas = $service->getBy(2);

        $this->assertDatabaseHas('agendas',$agendas);

    }

    public function test_store()
    {

        $service = new AgendaService;

        $data = [
            'title' => "cek",
            'description' => "cek cok"
        ];

        $agendas = $service->store($data);

        $this->assertDatabaseHas('agendas',$data);

    }

    public function test_update()
    {
        Agenda::factory(8)->create();
        $service = new AgendaService;

        $data = [
            'title' => "cek",
            'description' => "cek cok"
        ];

        $agendas = $service->update($data,2);

        $this->assertDatabaseHas('agendas',$data);

    }

    public function test_destroy()
    {
        Agenda::factory(8)->create();
        $service = new AgendaService;

        $agenda = $service->getBy(2);

        $service->destroy(2);

        $this->assertDatabaseMissing('agendas',$agenda);

    }

}
