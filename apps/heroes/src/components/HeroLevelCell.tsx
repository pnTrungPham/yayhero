import useMutationHeroLevelUp from "@src/hooks/useMutationHeroLevelup";
import { Button, Space, Tooltip } from "antd";
import { UpOutlined } from "@ant-design/icons";
import { yayHeroData } from "@src/localize";

function HeroLevelCell({ level, id }: { level: number; id: number }) {
  const { isLoading, mutateAsync } = useMutationHeroLevelUp();

  const performLevelUp = async () => {
    await mutateAsync(id);
  };

  return (
    <Space onClick={(e) => e.stopPropagation()}>
      <span className="level-badge">{level}</span>
      {yayHeroData.auth.canWrite && (
        <Tooltip title="Level up">
          <Button
            size="small"
            loading={isLoading}
            shape="circle"
            icon={<UpOutlined />}
            onClick={performLevelUp}
          />
        </Tooltip>
      )}
    </Space>
  );
}

export default HeroLevelCell;
