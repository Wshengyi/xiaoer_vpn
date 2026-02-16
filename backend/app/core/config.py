from pydantic_settings import BaseSettings, SettingsConfigDict


class Settings(BaseSettings):
    app_name: str = "xiaoer_vpn_api"
    app_env: str = "dev"
    database_url: str = "sqlite:///./xiaoer_vpn.db"
    cors_origins: str = "*"

    model_config = SettingsConfigDict(env_file='.env', extra='ignore')


settings = Settings()
