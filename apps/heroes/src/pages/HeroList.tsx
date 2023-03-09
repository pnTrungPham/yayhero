import HeroAttribute from "@src/components/HeroAttribute";
import { useHeroStore } from "@src/store/heroStore";
import {
  HeroAttributes,
  HeroClass,
  HeroModel,
  HERO_CLASS_COLORS,
} from "@src/types/heroes.type";
import { Button, Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import React, { CSSProperties } from "react";
import { Link } from "react-router-dom";

function HeroList() {
  const heroes = useHeroStore((s) => s.heroes);

  const columns: ColumnsType<HeroModel> = [
    {
      title: "ID",
      dataIndex: "id",
      key: "id",
      render: (value: string) => <span>{value}</span>,
    },
    {
      title: "Name",
      dataIndex: "name",
      key: "name",
      render: (value: string) => <span>{value}</span>,
    },
    {
      title: "Class",
      dataIndex: "class",
      key: "class",
      render: (value: string) => <span>{value}</span>,
    },
    {
      title: "Level",
      dataIndex: "level",
      key: "level",
      render: (value: number) => <span className="level-badge">{value}</span>,
    },
    {
      title: "Attributes",
      dataIndex: "attributes",
      key: "attributes",
      render: (attributes: HeroAttributes) => (
        <HeroAttribute attributes={attributes} />
      ),
    },
  ];

  const getRowStyle = (record: HeroModel): CSSProperties => {
    let heroClass: HeroClass = record.class;

    return {
      background: HERO_CLASS_COLORS[heroClass].color ?? "none",
    };
  };

  const rowSelection = {
    onChange: (selectedRowKeys: React.Key[], selectedRows: HeroModel[]) => {
      // TODO: implement onchange event
    },
  };

  return (
    <div>
      <header className="yayhero-herolist-title">
        <h4>Heroes</h4>
        <Link to="/heroes/add">
          <Button type="primary">Add Heroes</Button>
        </Link>
      </header>

      <Table
        rowKey={(record) => record.id}
        columns={columns}
        dataSource={heroes}
        onRow={(record) => {
          return {
            style: getRowStyle(record),
          };
        }}
        rowSelection={{
          type: "checkbox",
          ...rowSelection,
        }}
      />
      <Link to="/heroes/edit/123">Edit</Link>
    </div>
  );
}

export default HeroList;
